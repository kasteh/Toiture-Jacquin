@extends('layout.app')

@section('title', config('app.startup') . ' | Accueil')
@section('meta-description', 'Professionnels qualifiés pour tous vos travaux - Devis gratuit et sans engagement')

@push('styles')
    <style>
        .hero-section {
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url();
            background-size: cover;
            background-position: center;
            padding: 5rem 0;
            position: relative;
            z-index: 1;
        }
        
        .contact-card {
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            border: none;
        }
        
        .contact-title {
            color: var(--primary);
            font-weight: 700;
            border-bottom: 2px solid var(--primary);
        }
        
        .logo-style {
            max-height: 50px;
            width: auto;
        }
    </style>
@endpush

@section('content')
    <!-- Header Section -->
    <header class="bg-dark sticky-top">
        <div class="container">
            <div class="row py-3 align-items-center">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    <div class="h4 mb-0">
                        <a class="text-white text-decoration-none d-inline-flex align-items-center" 
                           href="tel:+33{{ substr(preg_replace('/\s+/', '', config('app.phone')), 1) }}">
                            <i class="fas fa-phone-alt me-3 fa-lg"></i>{{ config('app.phone') }}
                        </a>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex flex-column flex-md-row align-items-center justify-content-md-end">
                        <label for="phone" class="text-white fw-bold mb-2 mb-md-0 me-md-2">On vous rappelle gratuitement</label>
                        <form class="d-flex" method="POST" action="{{ route('phone') }}">
                            @csrf
                            <div class="input-group">
                                <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                       id="phone" placeholder="Votre numéro..." name="phone" 
                                       value="{{ old('phone') }}" required>
                                <button type="submit" class="btn btn-primary">OK</button>
                            </div>
                        </form>
                    </div>
                    @error('phone')
                        <div class="text-white text-center text-md-end mt-1"><small>{{ $message }}</small></div>
                    @enderror
                </div>
            </div>
        </div>
        
        <!-- Navbar Section -->
        <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="img-fluid logo-style">
                </a>
        
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
        
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        @foreach($headerCategories as $index => $headerCategory)
                            <li class="nav-item mx-2">
                                @php
                                    $targetCity = $currentCity ?? ($headerCities[$index] ?? $headerCities->first());
                                    $categoryUrl = route('category.show', [
                                        'city' => $targetCity->slug,
                                        'category' => $headerCategory->slug
                                    ]);
                                @endphp
                                <a class="nav-link" href="{{ $categoryUrl }}">{{ $headerCategory->name }}</a>
                            </li>
                        @endforeach
                        <li class="nav-item mx-2">
                            <a class="nav-link" href="{{ route('nos-agences') }}">Nos Agences</a>
                        </li>
                        <li class="nav-item mx-2">
                            <a class="nav-link" href="{{ route('devenir-partenaire') }}">Devenir Partenaire</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <div class="text-white">
                        <h1 class="display-4 fw-bold mb-4">
                            {{ isset($category) ? $category->name . ' à ' . $city->name : (isset($city) ? config('app.startup') . ' à ' . $city->name : config('app.startup')) }}
                        </h1>
                        <p class="lead mb-4">
                            Professionnels qualifiés pour tous vos travaux
                        </p>
                        <ul class="list-unstyled">
                            <li class="mb-2"><i class="fas fa-check-circle text-primary me-2"></i> Devis gratuit et sans engagement</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-primary me-2"></i> Artisans locaux qualifiés</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-primary me-2"></i> Intervention rapide</li>
                        </ul>
                    </div>
                </div>
    
                <div class="col-lg-5 offset-lg-1 col-md-8 mx-md-auto">
                    <div class="card contact-card bg-white">
                        <div class="card-body p-4">
                            <h2 class="card-title text-center py-2 mb-4 contact-title">DEVIS GRATUIT</h2>
                            <form method="POST" action="{{ route('contact') }}">
                                @csrf
                                <div class="mb-3">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           placeholder="Votre Nom" name="name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <input type="number" class="form-control @error('code') is-invalid @enderror" 
                                           placeholder="Code Postal" name="code" value="{{ old('code') }}" required>
                                    @error('code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           placeholder="Email" name="email" value="{{ old('email') }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                                           placeholder="Téléphone" name="phone" value="{{ old('phone') }}" required>
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <textarea class="form-control @error('message') is-invalid @enderror" rows="3" 
                                              placeholder="Description des travaux" name="message" required>{{ old('message') }}</textarea>
                                    @error('message')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary w-100 py-2 mt-2">Envoyer ma demande</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content Section -->
    <main class="container my-5">
        @yield('page-content')
    </main>

    <!-- Footer Section -->
    <footer class="bg-dark text-white py-4">
        <div class="container">
            <div class="text-center">
                <p class="mb-0">© {{ date('Y') }} {{ config('app.startup') }} - Tous droits réservés</p>
                <a href="{{ route('mentions-legales') }}" class="text-white-50 text-decoration-none">Mentions légales</a>
            </div>
        </div>
    </footer>
@endsection

@push('scripts')
    <script>
        // Validation en temps réel
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function(e) {
                const inputs = this.querySelectorAll('[required]');
                let isValid = true;
                
                inputs.forEach(input => {
                    if (!input.value.trim()) {
                        input.classList.add('is-invalid');
                        isValid = false;
                    }
                });
                
                if (!isValid) {
                    e.preventDefault();
                }
            });
        });
    </script>
@endpush