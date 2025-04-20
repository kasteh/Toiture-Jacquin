@extends('layout.app')

@section('meta')
    <title>{{ config('app.startup') }} | Liste des activités</title>
@endsection

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                    <div class="card-body bg-primary text-white p-5 text-center">

                        <h2 class="mb-4 fw-bold fs-3">🛠️ Sélectionnez une activité</h2>

                        <form 
                            class="form d-flex flex-column flex-md-row justify-content-center align-items-stretch gap-3" 
                            onsubmit="goToPageCategory(event)"
                        >
                            <div class="form-group flex-fill">
                                <select 
                                    class="form-select form-select-lg bg-white text-dark rounded-3 px-4 py-2 border-0 shadow-sm w-100" 
                                    id="categorySelect" 
                                    required
                                >
                                    <option value="">🔽 Sélectionner une activité</option>
                                    @foreach($categories as $listCategory)
                                        <option value="{{ $listCategory['slug'] }}">🔧 {{ $listCategory['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="d-grid">
                                <button 
                                    type="submit" 
                                    class="btn btn-light text-primary fw-bold px-4 py-2 rounded-pill shadow-sm"
                                >
                                    Valider
                                </button>
                            </div>
                        </form>

                        <div class="mt-4" id="select-message-error" style="display:none;">
                            <div class="alert alert-warning py-2 px-3 mb-0 d-inline-block rounded-pill shadow-sm">
                                <small>Veuillez sélectionner une activité.</small>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Section Catégories/Services -->
    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-5">Nos activités</h2>
                <!-- Affichage de 4 catégories aléatoires -->
                @php
                    $randomCategories = isset($headerCategories) && $headerCategories->count() > 0 
                        ? $headerCategories->random(min(3, $headerCategories->count()))
                        : collect([]);
                @endphp
                
                @php
                    $host = request()->getHost();
                    $subdomain = explode('.', $host)[0];
                    $mainDomain = parse_url(config('app.url'), PHP_URL_HOST);
                    $citySlug = null;
                
                    // Si on est sur un sous-domaine, on l'utilise comme slug
                    if ($subdomain !== 'www' && $subdomain !== $mainDomain) {
                        $citySlug = $subdomain;
                    } 
                    // Sinon, on prend une ville au hasard
                    elseif (!isset($currentCity)) {
                        $citySlug = \App\City::inRandomOrder()->first()?->slug ?? 'gagny';
                    } 
                    // Si la ville est injectée depuis le contrôleur
                    else {
                        $citySlug = $currentCity->slug;
                    }
                @endphp
            <div class="row g-3 justify-content-center">
                @foreach($headerCategories->slice(0) as $category)
                <div class="col-auto">
                    <a href="{{ route('category.show', ['city' => $citySlug, 'category' => $category->slug]) }}" class="badge-category">
                        <div class="d-flex align-items-center">
                            @if($category->icon)
                            <div class="badge-icon me-2">
                                <i class="{{ $category->icon }}"></i>
                            </div>
                            @endif
                            <span>{{ $category->name }}</span>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    
    <!-- Section Articles -->
    @include('partials.articles');
    
    <!-- Section CTA Dynamique -->
    @include('partials.cta');  
@endsection

@push('styles')
<style>
    /* Styles pour la section articles */
    .card-img-top {
        height: 200px;
        object-fit: cover;
        border-top-left-radius: 12px;
        border-top-right-radius: 12px;
    }
    
    /* Article vedette */
    .featured-article {
        min-height: 500px;
    }
    
    .featured-article .card-img-top {
        height: 300px;
    }
    
    /* Effet hover sur les cartes */
    .modern-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: none;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }
    
    .modern-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1) !important;
    }
    
    /* Badge */
    .badge {
        font-size: 0.8rem;
        font-weight: 500;
        letter-spacing: 0.5px;
        padding: 5px 10px;
    }
    
    /* Section CTA */
    .cta-section {
        background: {{ App\Setting::get('primary_color', '#4361ee') }};
        position: relative;
        overflow: hidden;
    }
    
    .cta-section::before {
        content: '';
        position: absolute;
        top: -50px;
        right: -50px;
        width: 200px;
        height: 200px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }
    
    .cta-section::after {
        content: '';
        position: absolute;
        bottom: -80px;
        left: -80px;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 50%;
    }
    
    .cta-card {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        position: relative;
        z-index: 1;
    }
    
    .form-control {
        height: 60px;
        border-radius: 8px 0 0 8px !important;
        border: none;
    }
    
    .btn-light {
        background: white;
        border-radius: 0 8px 8px 0 !important;
        font-weight: 600;
        transition: all 0.3s;
    }
    
    .btn-light:hover {
        background: #f8f9fa;
        transform: translateY(-2px);
    }
    
    /* Animation */
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }

        /* Styles pour les badges de catégories */
        .badge-category {
        display: block;
        padding: 12px 20px;
        background: white;
        border-radius: 50px;
        color: var(--dark);
        text-decoration: none;
        font-weight: 500;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        border: 1px solid rgba(0, 0, 0, 0.05);
    }
    
    .badge-category:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
        color: var(--primary);
    }
    
    .badge-icon {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background: var(--primary);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
    }
    
    /* Animation au survol */
    .badge-category:hover .badge-icon {
        animation: bounce 0.5s;
    }
    
    @keyframes bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-5px); }
    }
    
    /* Responsive */
    @media (max-width: 992px) {
        .featured-article {
            min-height: auto;
        }
        
        .featured-article .card-img-top {
            height: 200px;
        }
        
        .cta-section::before,
        .cta-section::after {
            display: none;
        }
        
        .cta-card {
            padding: 2rem !important;
        }
    }

    @media (max-width: 768px) {
        .badge-category {
            padding: 10px 15px;
            font-size: 14px;
        }
        
        .badge-icon {
            width: 25px;
            height: 25px;
            font-size: 12px;
        }
    }
</style>
@endpush
    
@push('scripts')
<script>
    function goToPageCategory(event) {
        event.preventDefault();

        const selectedCategory = document.getElementById('categorySelect').value;
        const selectedCity = '{{ $city->slug }}';
        const APP_URL = "{{ config('app.url') }}".replace(/^https?:\/\//, '');

        if (selectedCategory) {
            const newUrl = `${window.location.protocol}//${selectedCity}.${APP_URL}/${selectedCategory}`;
            window.location.href = newUrl;
        } else {
            document.getElementById('select-message-error').style.display = 'block';
        }
    }
</script>
@endpush
