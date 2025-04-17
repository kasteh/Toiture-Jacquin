<?php

namespace App\Http\Controllers;

use App\{Agence, Category, City, Content, Departement};
use App\Http\Requests\{ContactRequest, PhoneRequest};
use App\Mail\{ContactMail, PhoneMail};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Mail, Cache, Log, DB};
use App\Helpers\SettingHelper;
use Exception;
use Illuminate\Support\Str;

class GeneralController extends Controller
{
    protected $headerCategories;
    protected $headerCities;
    protected $siteSettings;

    public function __construct()
    {
        $this->loadSharedData();
    }

    /**
     * Charge les données partagées entre toutes les vues
     */
    protected function loadSharedData(): void
    {
        $this->siteSettings = Cache::remember('site_settings', now()->addHours(12), function() {
            return [
                'primaryColor' => SettingHelper::get('primary_color', '#FF6600'),
                'heroImage' => SettingHelper::get('hero_image', '/images/default-hero.jpg'),
            ];
        });

        $this->headerCategories = Cache::remember('header_categories', now()->addHours(12), function() {
            return Category::inRandomOrder()
                ->limit(4)
                ->get(['id', 'name', 'slug']);
        });

        $this->headerCities = Cache::remember('header_cities', now()->addHours(12), function() {
            return City::with(['departement' => fn($q) => $q->select('code', 'name', 'slug')])
                ->inRandomOrder()
                ->limit(4)
                ->get(['id', 'name', 'slug', 'departement_code']);
        });
    }

    /**
     * Données de base pour les vues
     */
    protected function baseViewData(array $additional = []): array
    {
        return array_merge([
            'headerCategories' => $this->headerCategories,
            'headerCities' => $this->headerCities,
            'siteSettings' => $this->siteSettings,
            'currentCity' => session('current_city'),
        ], $additional);
    }

    /**
     * Page d'accueil principale
     */
    public function index(Request $request) 
    {
        if ($this->isSubdomainRequest($request)) {
            return $this->handleSubdomainRedirect($request);
        }
    
        return view('welcome', $this->baseViewData([
            'contents' => $this->getHomeContents(),
            'cities' => $this->getAllCitiesData(),
        ]));
    }

    /**
     * Récupère les contenus pour la page d'accueil
     */
    protected function getHomeContents()
    {
        return Cache::remember('home_contents', now()->addHour(), function() {
            return Content::with(['category'])
                ->select('*')
                ->get();
        });
    }

    /**
     * Récupère toutes les villes
     */
    protected function getAllCitiesData()
    {
        return Cache::remember('all_cities', now()->addDay(), function() {
            return City::orderBy('name')
                ->get(['id', 'name', 'slug', 'departement_code']);
        });
    }

    /**
     * Vérifie si la requête est pour un sous-domaine
     */
    protected function isSubdomainRequest(Request $request): bool
    {
        $host = parse_url($request->url(), PHP_URL_HOST);
        $mainDomain = parse_url(config('app.url'), PHP_URL_HOST);
        
        return $host !== $mainDomain && Str::endsWith($host, $mainDomain);
    }

    /**
     * Redirige vers la page de la ville correspondant au sous-domaine
     */
    protected function handleSubdomainRedirect(Request $request)
    {
        $subdomain = explode('.', $request->getHost())[0];
        return redirect()->route('city.index', ['city' => $subdomain]);
    }

    /**
     * Page d'accueil d'une ville
     */
    public function cityIndex(Request $request, City $city)
    {
        // Forcer la mise à jour de la ville courante
        session(['current_city' => $city->slug]);
        $request->attributes->add(['currentCity' => $city]);
        
        return view('categoriesIndex', $this->baseViewData([
            'city' => $city,
            'contents' => $this->getLatestContents(),
            'categories' => $this->getAllCategories(),
        ]));
    }

    /**
     * Actualise les données de la ville courante
     */
    protected function refreshCurrentCity(City $city, Request $request): void
    {
        Cache::forget("city_{$city->slug}");
        session()->forget('current_city');
        
        $freshCity = City::where('slug', $city->slug)->first();
        session(['current_city' => $freshCity->slug]);
        $request->attributes->add(['currentCity' => $freshCity]);
    }

    /**
     * Récupère les derniers contenus
     */
    protected function getLatestContents()
    {
        return Content::latest()
            ->limit(10)
            ->get(['id', 'title', 'slug', 'category_id', 'image']);
    }

    /**
     * Récupère toutes les catégories
     */
    protected function getAllCategories()
    {
        return Category::orderBy('name')
            ->get(['id', 'name', 'slug']);
    }

    /**
     * Affiche une catégorie pour une ville
     */
    public function show(Request $request, City $city, Category $category) 
    {
        return view('show', $this->baseViewData([
            'departement' => $this->getDepartementForCity($city),
            'city' => $this->resolveCurrentCity($request, $city->slug) ?? $city,
            'category' => $category,
        ]));
    }

    /**
     * Récupère le département pour une ville
     */
    protected function getDepartementForCity(City $city)
    {
        return $city->departement ?? $this->getDefaultDepartement();
    }

    /**
     * Résout la ville courante depuis la requête
     */
    protected function resolveCurrentCity(Request $request, string $citySlug): ?City
    {
        $hostParts = explode('.', $request->getHost());
        
        if (count($hostParts) > 1 && $hostParts[0] !== 'www') {
            return Cache::remember("city_{$hostParts[0]}", now()->addHour(), function() use ($hostParts) {
                return City::where('slug', $hostParts[0])->first(['id', 'name', 'slug', 'departement_code']);
            });
        }
        
        return City::where('slug', $citySlug)->first(['id', 'name', 'slug', 'departement_code']);
    }

    /**
     * Récupère le département par défaut
     */
    protected function getDefaultDepartement()
    {
        return Cache::remember('default_departement', now()->addDay(), function() {
            return Departement::where('slug', 'seine-saint-denis')
                ->first(['code', 'name', 'slug'])
                ?? Departement::first(['code', 'name', 'slug']);
        });
    }

    /**
     * Affiche un contenu spécifique
     */
    public function showText(City $city, Category $category, Content $content) 
    {
        return view('text', $this->baseViewData([
            'departement' => $this->getDepartementForCity($city),
            'city' => $city,
            'category' => $category,
            'content' => $content,
        ]));
    }

    /**
     * Affiche un contenu depuis un sous-domaine de contenu
     */
    public function showTextFromSubdomain(Request $request, string $contentSlug, string $citySlug, string $categorySlug)
    {
        session(['current_city' => $citySlug]);
    
        $city = $this->getCityBySlug($citySlug);
        $category = $this->getCategoryBySlug($categorySlug);
        $content = Content::forSlugVariations($contentSlug, $citySlug)
            ->where('category_id', $category->id)
            ->firstOrFail();
    
        return view('text', $this->baseViewData([
            'departement' => $this->getDepartementForCity($city),
            'city' => $city,
            'category' => $category,
            'content' => $content,
        ]));
    }

    /**
     * Récupère une ville par son slug
     */
    protected function getCityBySlug(string $slug)
    {
        return Cache::remember("city_{$slug}", now()->addHour(), function() use ($slug) {
            return City::where('slug', $slug)->firstOrFail(['id', 'name', 'slug', 'departement_code']);
        });
    }

    /**
     * Récupère une catégorie par son slug
     */
    protected function getCategoryBySlug(string $slug)
    {
        return Cache::remember("category_{$slug}", now()->addHour(), function() use ($slug) {
            return Category::where('slug', $slug)->firstOrFail(['id', 'name', 'slug']);
        });
    }

    /**
     * Récupère un contenu pour un sous-domaine de contenu
     */
    protected function getContentForSubdomain(string $contentSlug, string $citySlug, Category $category)
    {
        return Cache::remember("content_{$contentSlug}_{$category->id}", now()->addHour(), function() use ($contentSlug, $citySlug, $category) {
            $slugWithoutCity = str_replace('-' . strtolower($citySlug), '', $contentSlug);
            return Content::where('slug', 'LIKE', '%' . $slugWithoutCity . '%')
                ->where('category_id', $category->id)
                ->firstOrFail(['id', 'title', 'slug', 'text', 'category_id', 'image']);
        });
    }

    /**
     * Traite le formulaire de contact
     */
    public function contact(ContactRequest $request)
    {
        return $this->handleMailSending(
            new ContactMail($request->validated()),
            'Votre message nous a été envoyé avec succès, Merci'
        );
    }

    /**
     * Traite le formulaire de téléphone
     */
    public function phone(PhoneRequest $request)
    {
        return $this->handleMailSending(
            new PhoneMail($request->validated()),
            'Votre numéro nous a été envoyé avec succès, nous vous rappellerons dès que possible, Merci'
        );
    }

    /**
     * Gère l'envoi des emails
     */
    protected function handleMailSending($mailable, string $successMessage)
    {
        try {
            Mail::send($mailable);
            return back()->with('success', $successMessage);
        } catch (Exception $e) {
            Log::error('Mail sending failed: ' . $e->getMessage());
            return back()->with('danger', 'Une erreur est survenue, veuillez réessayer');
        }
    }

    /**
     * API de recherche des villes
     */
    public function getAllCities(Request $request)
    {
        $term = $request->get('q', '');
    
        return Cache::remember("cities_search_{$term}", now()->addMinutes(30), function() use ($term) {
            return City::when($term, fn($q) => $q->where('name', 'like', "%{$term}%"))
                ->orderBy('name')
                ->limit(20)
                ->get(['name', 'slug']);
        });
    }

    /**
     * Page des mentions légales
     */
    public function mentionsLegales()
    {
        return view('mentions-legales', $this->baseViewData());
    }
}