<?php

namespace App\Http\Controllers;

use App\Content;
use App\Category;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Services\ChatGPTServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ChatGPTController extends Controller
{
    protected $chatGPT;

    public function __construct(ChatGPTServices $chatGPT)
    {
        $this->chatGPT = $chatGPT;
    }

    public function index()
    {
        return view('admin.chatgpt.index');
    }

    public function process(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'message' => 'required|string|min:2'
            ]);
    
            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }
    
            $message = $request->input('message');
            $response = $this->chatGPT->processMessage($message);
            
            return response()->json([
                'message' => 'Success',
                'chatgpt_response' => $response
            ], 200);
    
        } catch (\Exception $e) {
            Log::error('ChatGPTController Error: '.$e->getMessage());
            return response()->json([
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function generateContent(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'theme' => 'required|string|min:3',
            'categories_count' => 'required|integer|min:1|max:20',
            'articles_count' => 'required|integer|min:1|max:20'
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }
    
        try {
            $theme = $request->input('theme');
            $categoriesCount = $request->input('categories_count');
            $articlesCount = $request->input('articles_count');
    
            // Générer les noms de catégories
            $categoriesPrompt = "Génère $categoriesCount catégories sur le thème '$theme'. Liste les simplement séparées par des virgules, sans numérotation ni commentaires.";
            $categoriesResponse = $this->chatGPT->processMessage($categoriesPrompt);
            $categories = array_map('trim', explode(',', $categoriesResponse));
    
            $createdCategories = [];
            $createdArticles = 0;
    
            foreach ($categories as $categoryName) {
                if (empty($categoryName)) continue;
    
                $slug = Str::slug($categoryName);
                $category = Category::firstOrCreate(
                    ['slug' => $slug],
                    ['name' => $categoryName]
                );
    
                $createdCategories[] = $category;
    
                // Générer les articles pour cette catégorie
                for ($i = 1; $i <= $articlesCount; $i++) {
                    // Générer un titre unique
                    $titlePrompt = "Génère un titre unique pour un article dans la thématique '$categoryName'. 
                        Le titre ne doit pas contenir '$categoryName' ni 'Article X'. 
                        Il doit être accrocheur et professionnel.
                        À la fin de chaque titre, mets [ville], c'est une variable déjà gérée côté backend, mais laisse simplement [ville] entre crochets, sans remplacer par une valeur. 
                        Répondre avec le titre seul, sans guillemets ni commentaires.";
                    
                    $articleTitle = trim($this->chatGPT->processMessage($titlePrompt));

                    // Générer le slug de l'article
                    $slugPrompt = "Génère un slug de 3 à 4 mots seulement et important pour l'article '$articleTitle'. 
                            Le slug doit inclure '[ville]' à la fin, sans remplacer cette variable. 
                            Le slug doit être en minuscule et utiliser des tirets pour séparer les mots. 
                            Répondre uniquement avec le slug, sans guillemets ni commentaires.";

                    $rawSlug = trim($this->chatGPT->processMessage($slugPrompt));
                    $slug = $this->forceVilleInSlug($rawSlug);
                    
                    // Générer le contenu de l'article
                    $contentPrompt = "Rédige un article de 300 mots sur le thème '$articleTitle' (domaine général: '$categoryName'). 
                                    Format: Texte brut uniquement, sans balises HTML. 
                                    Structure claire avec paragraphes séparés par des sauts de ligne.
                                    Style professionnel et technique.
                                    En respect du demande SEO de Google";
    
                    $contentResponse = $this->chatGPT->processMessage($contentPrompt);
    
                    Content::create([
                        'category_id' => $category->id,
                        'title' => $articleTitle,
                        'slug' => $slug,
                        'text' => $contentResponse,
                        'image' => $this->generatePlaceholderImage($articleTitle)
                    ]);
    
                    $createdArticles++;
                }
            }
    
            return response()->json([
                'success' => true,
                'message' => 'Génération terminée',
                'categories' => count($createdCategories),
                'articles' => $createdArticles
            ]);
    
        } catch (\Exception $e) {
            Log::error('Content generation error: '.$e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la génération: '.$e->getMessage()
            ], 500);
        }
    }

    private function generatePlaceholderImage($title)
    {
        $baseUrl = "https://placehold.co/450x450";
        return $baseUrl . urlencode(Str::limit($title, 30, ''));
    }

    private function forceVilleInSlug($slug)
    {
        // On retire toute version déjà présente (ville en dur ou la variable)
        $slug = preg_replace('/(-)?(ville|\[ville\])$/', '', $slug);

        // On force l'ajout de [ville] à la fin
        return rtrim($slug, '-') . '-[ville]';
    }
}