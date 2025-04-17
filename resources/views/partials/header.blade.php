<header>
    <!-- Barre de contact téléphonique -->
    <div class="bg-primary py-2">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="d-flex align-items-center justify-content-center justify-content-md-start">
                        <i class="fas fa-phone-alt text-white me-2"></i>
                        <a href="tel:+33{{ str_replace(' ', '', substr(config('app.phone'), 1)) }}" 
                           class="text-white fw-bold text-decoration-none">
                            {{ config('app.phone') }}
                        </a>
                    </div>
                </div>
                
                <div class="col-md-6 mt-2 mt-md-0">
                    <form class="d-flex justify-content-center justify-content-md-end" method="POST" action="{{ route('phone') }}">
                        @csrf
                        <div class="input-group" style="max-width: 300px;">
                            <input type="tel" 
                                   class="form-control form-control-sm @error('phone') is-invalid @enderror" 
                                   placeholder="Votre numéro" 
                                   name="phone" 
                                   value="{{ old('phone') }}"
                                   required>
                            <button class="btn btn-light btn-sm" type="submit">
                                <i class="fas fa-paper-plane me-1"></i> Rappelez-moi
                            </button>
                        </div>
                        @error('phone')
                            <div class="invalid-feedback d-block text-center text-md-end">{{ $message }}</div>
                        @enderror
                    </form>
                </div>
            </div>
        </div>
    </div>

    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ config('app.url') }}">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" height="100">
            </a>
    
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
    
            @php
                // Détection du protocole et configuration
                $isSecure = request()->secure();
                $protocol = $isSecure ? 'https://' : 'http://';
                $currentHost = request()->getHost();
                $mainDomain = parse_url(config('app.url'), PHP_URL_HOST);
    
                // Gestion du port (seulement en développement)
                $port = '';
                if (app()->environment('local')) {
                    $portPart = parse_url(config('app.url'), PHP_URL_PORT);
                    $port = $portPart ? ':'.$portPart : '';
                }
    
                // Détection si on est sur un sous-domaine de ville (par exemple "city.localhost")
                $isCitySubdomain = (strpos($currentHost, $mainDomain) !== false) && ($currentHost !== $mainDomain);
    
                // Ville courante - Si sur le domaine principal (localhost:8000), récupère la ville de la session ou une ville aléatoire
                $citySlug = session('current_city') ?? ($isCitySubdomain ? explode('.', $currentHost)[0] : null);
                
                // Si la ville n'est pas dans la session, on prend une ville aléatoire (pas de ville par défaut)
                $cityModel = null;
                if ($citySlug) {
                    // Recherche de la ville par slug
                    $cityModel = Cache::remember("city_{$citySlug}", now()->addHour(), function() use ($citySlug) {
                        return \App\City::where('slug', $citySlug)->first();
                    });
                }
    
                // Si aucune ville n'est trouvée, sélectionne une ville aléatoire
                if (!$cityModel) {
                    $cityModel = \App\City::inRandomOrder()->first();
                }
    
                // Récupération du département lié à la ville
                $departement = $cityModel?->departement ?? \App\Departement::first();
            @endphp
    
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @foreach($headerCategories as $category)
                        <li class="nav-item">
                            <!-- URL dynamique avec protocole et port adaptés -->
                            <a class="nav-link" href="{{ $protocol }}{{ $citySlug ?? $cityModel->slug }}.{{ $mainDomain }}{{ $port }}/{{ $category->slug }}">
                                {{ $category->name }}
                            </a>
                        </li>
                    @endforeach
                
                    <!-- Liens statiques toujours vers domaine principal -->
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/agences') }}">Nos agences</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/agences/devenir-partenaire') }}">Devenir partenaire</a>
                    </li>
                </ul>            
            </div>
        </div>
    </nav>
    
    <!-- Hero Section -->
    <section class="hero-section p-5" style="background-image: url('{{ asset('storage/' . $siteSettings['heroImage']) }}'); background-size: cover; background-repeat: no-repeat; position: relative; color: #fff;">
        <!-- Container for Overlay, affecting only the background -->
        <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); z-index: 1;"></div>

        <!-- Content above the overlay -->
        <div class="container h-100" style="position: relative; z-index: 2;">
            <div class="row h-100 align-items-center">
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <div class="text">
                        <h1 class="display-3 text-white fw-bold mb-4">{{ config('app.startup') }}</h1>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="card shadow-lg border-0 overflow-hidden modern-card">
                        <div class="card-header">
                            <h3 class="text-center mb-0 text-white">Demande de devis</h3>
                        </div>
                        <div class="card-body p-4">
                            <form method="POST" action="{{ route('contact') }}">
                                @csrf
                                <div class="mb-3">
                                    <input type="text" class="form-control form-control-lg" placeholder="Votre nom" name="name" required>
                                </div>
                                <div class="mb-3">
                                    <input type="email" class="form-control form-control-lg" placeholder="Votre email" name="email" required>
                                </div>
                                <div class="mb-3">
                                    <input type="tel" class="form-control form-control-lg" placeholder="Votre téléphone" name="phone" required>
                                </div>
                                <div class="mb-3">
                                    <textarea class="form-control form-control-lg" rows="5" placeholder="Description des travaux" name="message" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary btn-lg w-100">
                                    Envoyer ma demande
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</header>

<style>
    .navbar-nav .nav-link {
        position: relative;
        transition: color 0.3s ease, padding-bottom 0.3s ease;
    }

    .navbar-nav .nav-link::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 2px;
        background-color: var(--primary);
        transform: scaleX(0);
        transform-origin: bottom right;
        transition: transform 0.3s ease;
    }

    .navbar-nav .nav-link:hover::after {
        transform: scaleX(1);
        transform-origin: bottom left;
    }

    .navbar-nav .nav-link:hover {
        color: var(--primary);
        padding-bottom: 8px;
    }
    
    .hero-section {
        min-height: 600px;
    }
    
    @media (max-width: 992px) {
        .hero-section {
            min-height: auto;
            padding: 3rem 0 !important;
        }
        
        .hero-section .row {
            flex-direction: column;
        }
        
        .hero-section .col-lg-6 {
            margin-bottom: 2rem;
            text-align: center;
        }
        
        .hero-section h1 {
            font-size: 2.5rem !important;
        }
    }

    /* Style pour les placeholders */
    ::placeholder {
        color: #6c757d;
        opacity: 1;
    }

    :-ms-input-placeholder {
        color: #6c757d;
    }

    ::-ms-input-placeholder {
        color: #6c757d;
    }
</style>