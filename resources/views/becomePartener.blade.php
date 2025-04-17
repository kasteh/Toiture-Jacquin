@extends('layout.app')

@section('meta')
    <title>{{ config('app.startup') }} | Devenir Partenaire</title>
    <meta name="description" content="Rejoignez notre réseau de partenaires professionnels. Soumettez votre demande pour devenir partenaire agréé.">
@endsection

@section('style')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-pxIL2D3+9Fgik7T2ZmcXDbXDkpjo8/Ba5bUD1D+dr3I=" crossorigin=""/>
<style>
    .partner-section {
        background-color: #f8f9fa;
        padding: 3rem 0;
    }

    .partner-card {
        border: none;
        border-radius: 0.5rem;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
    }

    .section-title {
        position: relative;
        padding-bottom: 1rem;
        margin-bottom: 2rem;
    }

    .section-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 80px;
        height: 4px;
        background: linear-gradient(90deg, #0d6efd 0%, #0b5ed7 100%);
        border-radius: 2px;
    }

    #map {
        height: 300px;
        border-radius: 0.375rem;
        border: 1px solid #dee2e6;
    }

    .form-control:focus {
        border-color: #86b7fe;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }

    .btn-partner {
        background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%);
        border: none;
        transition: all 0.3s ease;
    }

    .btn-partner:hover {
        transform: translateY(-2px);
        box-shadow: 0 0.5rem 1rem rgba(13, 110, 253, 0.3);
    }
</style>
@endsection

@section('content')
<section class="partner-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-10">
                <div class="card partner-card overflow-hidden">
                    <div class="row g-0">
                        <!-- Partie Image -->
                        <div class="col-md-6 d-none d-md-block">
                            <div class="h-100 w-100" style="background: url('/images/partenaire.jpg') center/cover no-repeat;"></div>
                        </div>

                        <!-- Partie Formulaire -->
                        <div class="col-md-6">
                            <div class="card-body p-4 p-md-5">
                                <h1 class="section-title text-center">Devenir Partenaire</h1>

                                <form method="POST" action="{{ route('partenaire') }}" class="needs-validation" novalidate>
                                    @csrf
                                    <div class="row g-3">
                                        <!-- Nom entreprise -->
                                        <div class="col-12">
                                            <label for="agenceName" class="form-label fw-semibold">Nom de l'entreprise</label>
                                            <input type="text" class="form-control @error('agence_name') is-invalid @enderror"
                                                   id="agenceName" name="agence_name"
                                                   placeholder="Nom de votre entreprise"
                                                   value="{{ old('agence_name') }}" required>
                                            @error('agence_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Adresse -->
                                        <div class="col-12">
                                            <label for="agenceAdress" class="form-label fw-semibold">Adresse complète</label>
                                            <input type="text" class="form-control @error('agence_adress') is-invalid @enderror"
                                                   id="agenceAdress" name="agence_adress"
                                                   placeholder="Adresse de votre entreprise"
                                                   value="{{ old('agence_adress') }}" required>
                                            @error('agence_adress')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Nom complet -->
                                        <div class="col-12">
                                            <label for="agence_owner_name" class="form-label fw-semibold">Votre nom complet</label>
                                            <input type="text" class="form-control @error('agence_owner_name') is-invalid @enderror"
                                                   id="agence_owner_name" name="agence_owner_name"
                                                   placeholder="Votre nom et prénom"
                                                   value="{{ old('agence_owner_name') }}" required>
                                            @error('agence_owner_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Email -->
                                        <div class="col-12">
                                            <label for="email" class="form-label fw-semibold">Email professionnel</label>
                                            <input type="email" class="form-control @error('agence_owner_email') is-invalid @enderror"
                                                   id="email" name="agence_owner_email"
                                                   placeholder="email@votre-entreprise.com"
                                                   value="{{ old('agence_owner_email') }}" required>
                                            @error('agence_owner_email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Téléphone -->
                                        <div class="col-12 mb-2">
                                            <label for="phone" class="form-label fw-semibold">Téléphone</label>
                                            <input type="tel" class="form-control @error('agence_owner_phone') is-invalid @enderror"
                                                   id="phone" name="agence_owner_phone"
                                                   placeholder="06 12 34 56 78"
                                                   value="{{ old('agence_owner_phone') }}" required>
                                            @error('agence_owner_phone')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="d-grid mt-4">
                                        <button type="submit" class="btn btn-primary btn-lg btn-partner">
                                            <i class="fas fa-paper-plane me-2"></i> Envoyer la demande
                                        </button>
                                    </div>
                                </form>

                            </div> <!-- /card-body -->
                        </div> <!-- /col formulaire -->
                    </div> <!-- /row g-0 -->
                </div>
            </div>
        </div>
    </div>
</section>
@endsection


@section('script')
<script>
    (() => {
        'use strict';
        const forms = document.querySelectorAll('.needs-validation');
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    })();
</script>
@endsection