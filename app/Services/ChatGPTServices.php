<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatGPTServices
{
    protected $apiKey;
    protected $apiUrl = 'https://api.openai.com/v1/chat/completions';

    public function __construct()
    {
        $this->apiKey = config('services.openai.key');
    }

    public function processMessage(string $message)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ])->post($this->apiUrl, [
                'model' => 'gpt-4',
                'messages' => [[
                    'role' => 'user',
                    'content' => $message . "\n\nImportant : Répondre avec le texte uniquement, sans aucune balise HTML, sans <p>, </p>, <br> ou autres balises. Juste le texte brut avec des sauts de ligne normaux."
                ]],
                'temperature' => 0.7,
            ]);
    
            if ($response->successful()) {
                $content = $response->json()['choices'][0]['message']['content'];
                
                $content = strip_tags($content);
                $content = html_entity_decode($content);
                $content = trim($content);
                
                return $content;
            }
    
            Log::error('ChatGPT API Error: ' . $response->body());
            return "Désolé, je n'ai pas pu obtenir de réponse de ChatGPT.";
    
        } catch (\Exception $e) {
            Log::error('ChatGPT Service Error: ' . $e->getMessage());
            return "Erreur de service: " . $e->getMessage();
        }
    }
}