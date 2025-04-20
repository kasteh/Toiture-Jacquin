<footer class="text-white pt-0 mt-5" style="background-color:var(--primary); position: relative;"> <!-- bleu Bootstrap -->
    <!-- Vague visible en haut -->
    <div style="position: absolute; top: -80px; left: 0; width: 100%; overflow: hidden; line-height: 0;">
        <svg viewBox="0 0 500 150" preserveAspectRatio="none" style="height: 100px; width: 100%;">
            <path d="M0.00,49.98 C150.00,150.00 349.91,-50.00 500.00,49.98 L500.00,150.00 L0.00,150.00 Z" 
                  style="stroke: none; fill: var(--primary);"></path>
        </svg>
    </div>

    <div class="container pt-5 pb-5">
        <div class="row">
            <div class="col-md-4">
                <h5 class="text-white">À propos</h5>
                <p class="text-white-50">{{ $siteSettings['aboutFooter'] ?? $aboutFooter }}</p>
            </div>
            <div class="col-md-4 mb-4 mb-md-0">
                <h5 class="mb-3 text-white">Liens rapides</h5>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <a href="{{ route('mentions-legales') }}" class="text-decoration-none text-white-50 hover:text-white transition">Mentions légales</a>
                    </li>
                </ul>
            </div>
            <div class="col-md-4">
                <h5 class="mb-3 text-white">Rappel immédiat</h5>
                <form method="POST" action="{{ route('phone') }}" class="needs-validation" novalidate>
                    @csrf
                    <div class="mb-3">
                        <input type="tel"
                               class="form-control bg-white text-dark @error('phone') is-invalid @enderror"
                               placeholder="Votre numéro"
                               name="phone"
                               value="{{ old('phone') }}"
                               required>
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-light w-100 py-2 text-primary">
                        <i class="fas fa-phone-alt me-2"></i>Être rappelé
                    </button>
                </form>
            </div>
        </div>
        <hr class="my-4 bg-light">
        <div class="text-center text-white-50">
            <small>&copy; {{ date('Y') }} {{ config('app.name') }}. Tous droits réservés.</small>
        </div>
    </div>
</footer>
