@extends('layout.app')

@section('title', config('app.startup') . ' | Accueil')
@section('meta-description', 'Trouvez des professionnels qualifiés pour vos travaux - Devis gratuit et sans engagement')

@section('content')
<div class="container-fluid px-0">
    <!-- Barre de recherche -->
    <section class="py-4">
        <div class="search-container modern-card">
            <div class="text-center mb-4">
                <h3 class="display-6 fw-bold mb-2">Trouvez des professionnels près de chez vous</h3>
                <p class="lead text-muted">Tapez une lettre et choisissez votre ville</p>
            </div>

            <div class="row align-items-center g-3">
                <div class="col-md-8 mb-3 mb-md-0 position-relative">
                    <select id="city-select" class="form-select form-select-lg">
                        <option></option>
                    </select>
                    <div id="city-loading">
                        <div class="spinner-border spinner-border-sm text-primary" role="status">
                            <span class="visually-hidden">Chargement...</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <button id="city-search-btn" class="btn btn-primary btn-lg w-100 py-3" disabled>
                        <i class="fas fa-search me-2"></i> Trouver
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Section Catégories/Services -->
    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-5">Nos activités</h2>
            
            @php
                $host = request()->getHost();
                $mainDomain = parse_url(config('app.url'), PHP_URL_HOST);
                $subdomain = str_replace(".{$mainDomain}", '', $host);
                
                if ($subdomain !== $host) {
                    $citySlug = $subdomain;
                } else {
                    $citySlug = \App\City::inRandomOrder()->first();
                }
            @endphp
            
            <div class="row g-3 justify-content-center">
                @foreach($headerCategories as $category)
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

    <!-- Section Texte + Image -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row align-items-center">
                <!-- Colonne Image -->
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <div style="
                        background-image: url('{{ asset('storage/' . $siteSettings['heroImage']) }}');
                        background-size: cover;
                        background-repeat: no-repeat;
                        background-position: center;
                        height: 100%;
                        min-height: 300px;
                        border-radius: 0.5rem;
                        box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.15);
                    "></div>
                </div>
                
                <!-- Colonne Texte -->
                <div class="col-lg-6">
                    <h6 class="text-uppercase fw-semibold mb-2" style="color: var(--primary);">
                        {{ $siteSettings['heroSmallTitle'] }}
                    </h6>
                    <h2 class="fw-bold mb-4">{{ $siteSettings['heroMainTitle'] }}</h2>
                    <p class="mb-4">{{ $siteSettings['heroDescription'] }}</p>
                    
                    @php
                        $bullets = $siteSettings['heroBullets'] ?? [];
                        $chunks = array_chunk($bullets, ceil(count($bullets) / 2));
                    @endphp
                    
                    <!-- Liste en 2 colonnes -->
                    <div class="row">
                        @foreach($chunks as $chunk)
                            <div class="col-6">
                                <ul class="list-unstyled">
                                    @foreach($chunk as $bullet)
                                        <li class="mb-3 d-flex align-items-start">
                                            <i class="bi bi-check-circle-fill me-2 fs-5 text-primary"></i>
                                            <span class="fw-semibold text-dark">{{ $bullet }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section FAQ En Savoir Plus -->
    <section class="py-5 bg-white">
        <div class="container">
            <div class="text-center mb-4">
                <h2 class="fw-bold">{{ $siteSettings['faqMainTitle'] }}</h2>
            </div>

            <div class="text-center">
                <button class="btn btn-primary px-4 py-2 rounded-pill" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse" aria-expanded="false" aria-controls="faqCollapse">
                    En savoir plus
                </button>
            </div>

            <div class="collapse mt-4" id="faqCollapse">
                <div class="card card-body shadow-sm border-0">
                    {!! $siteSettings['presentationContent'] !!}
                </div>
            </div>
        </div>
    </section>
</div>
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
        background: {{ $siteSettings['primaryColor'] ?? '#4361ee' }};
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
    $(document).ready(function () {
        // Initialisation de Select2
        const $citySelect = $('#city-select');
        $citySelect.select2({
            placeholder: 'Entrez le nom de votre ville',
            allowClear: false,
            minimumInputLength: 1,
            width: '100%',
            dropdownParent: $('body'),
            ajax: {
                url: '/api/cities',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    $('#city-loading').show();
                    return { q: params.term };
                },
                processResults: function (data) {
                    $('#city-loading').hide();
                    return {
                        results: data.map(city => ({
                            id: city.slug,
                            text: city.name
                        }))
                    };
                },
                error: function () {
                    $('#city-loading').hide();
                    $('#city-error').removeClass('d-none');
                }
            },
            language: {
                inputTooShort: () => "Tapez au moins une lettre",
                noResults: () => "Aucune ville trouvée",
                searching: () => "Recherche..."
            }
        });

        $citySelect.on('select2:select', function () {
            $('#city-search-btn').prop('disabled', false);
        });

        $('#city-search-btn').on('click', function () {
            const slug = $citySelect.val();
            if (slug) {
                window.location.href = `${window.location.protocol}//${slug}.${window.location.host}`;
            }
        });

        // Gestion du formulaire téléphone
        $('#phoneForm').on('submit', function(e) {
            e.preventDefault();
            
            const phone = $('input[name="phone"]').val();
            if (!phone.match(/^[0-9]{10}$/)) {
                alert('Veuillez entrer un numéro valide à 10 chiffres');
                return;
            }
            
            // Animation pendant l'envoi
            const submitBtn = $(this).find('button[type="submit"]');
            submitBtn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Envoi en cours...');
            submitBtn.prop('disabled', true);
            
            // Envoi AJAX
            $.ajax({
                url: '/phone',
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    submitBtn.html('<i class="fas fa-check me-2"></i> Envoyé !');
                    setTimeout(() => {
                        submitBtn.html('<i class="fas fa-paper-plane me-2"></i> Envoyer');
                        submitBtn.prop('disabled', false);
                        $('#phoneForm')[0].reset();
                    }, 2000);
                },
                error: function() {
                    submitBtn.html('<i class="fas fa-paper-plane me-2"></i> Envoyer');
                    submitBtn.prop('disabled', false);
                    alert('Une erreur est survenue, veuillez réessayer');
                }
            });
        });
    });
</script>
@endpush