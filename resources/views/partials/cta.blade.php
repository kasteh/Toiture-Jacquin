<section class="py-5 cta-section mb-5">
    <div class="container">
        <div class="cta-card p-4 p-lg-5 rounded-4 shadow-lg">
            <div class="row align-items-center">
                <div class="col-lg-7 mb-4 mb-lg-0">
                    <h2 class="display-6 fw-bold text-white mb-3">Besoin d'aide rapidement ?</h2>
                    <p class="lead text-white-50 mb-0">Laissez-nous votre numéro, un conseiller vous rappelle sous 24h</p>
                </div>
                <div class="col-lg-5">
                    <form id="phoneForm" action="/phone" method="POST">
                        @csrf
                        <div class="input-group">
                            <input type="tel" 
                                   class="form-control form-control-lg" 
                                   name="phone" 
                                   placeholder="Votre numéro de téléphone" 
                                   required
                                   pattern="[0-9]{10}"
                                   title="Entrez un numéro à 10 chiffres">
                            <button class="btn btn-light btn-lg px-4" type="submit">
                                <i class="fas fa-paper-plane me-2"></i> Envoyer
                            </button>
                        </div>
                        <small class="text-white-50 mt-2 d-block">Service gratuit - Sans engagement</small>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>