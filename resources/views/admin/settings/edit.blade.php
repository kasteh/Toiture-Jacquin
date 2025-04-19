@extends('layout.admin')

@section('content')
    <div class="container">
        <h2>Paramètres du site</h2>
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Champ pour la couleur principale -->
            <div class="mb-3">
                <label for="primary_color" class="form-label">Couleur principale</label>
                <input type="color" name="primary_color" id="primary_color"
                    class="form-control form-control-color"
                    value="{{ $settings['primary_color'] ?? '#4361ee' }}">
            </div>

            <!-- Champ pour l'image de fond -->
            <hr>
            <div class="mb-3">
                <label for="hero_image" class="form-label">Image de fond de la section héro</label>
                <input type="file" name="hero_image" id="hero_image" class="form-control" accept="image/*">
                
                <!-- Affichage de l'image actuelle (si elle existe) -->
                @if(isset($settings['hero_image']))
                    <div class="mt-2">
                        <img src="{{ asset('storage/' . $settings['hero_image']) }}" alt="Hero Image" class="img-fluid" style="max-height: 200px;">
                    </div>
                @endif
            </div>
            
            <!-- Texte personnalisé sur la section héro -->
            <hr>
            <h4 class="mt-4">Contenu de la section texte et image</h4>
            
            <!-- Petit titre (h6) -->
            <div class="mb-3">
                <label for="hero_small_title" class="form-label">Petit titre</label>
                <input type="text" name="hero_small_title" id="hero_small_title" class="form-control"
                    value="{{ $settings['hero_small_title'] ?? '' }}">
            </div>
            
            <!-- Grand titre (h2) -->
            <div class="mb-3">
                <label for="hero_main_title" class="form-label">Grand titre</label>
                <input type="text" name="hero_main_title" id="hero_main_title" class="form-control"
                    value="{{ $settings['hero_main_title'] ?? '' }}">
            </div>
            
            <!-- Description (p) -->
            <div class="mb-3">
                <label for="hero_description" class="form-label">Description</label>
                <textarea name="hero_description" id="hero_description" class="form-control" rows="4">{{ $settings['hero_description'] ?? '' }}</textarea>
            </div>
            
            <!-- Liste des avantages -->
            <div class="mb-3">
                <label for="hero_bullets" class="form-label">Liste des avantages (séparés par une virgule)</label>
                <input type="text" name="hero_bullets" id="hero_bullets" class="form-control"
                    value="{{ $settings['hero_bullets'] ?? 'Intervention rapide,Professionnels certifiés,Devis gratuit,Satisfaction garantie' }}">
                <small class="text-muted">Exemple : Intervention rapide,Professionnels certifiés,Devis gratuit,Satisfaction garantie</small>
            </div>
             <hr>
             <h4 class="mt-4">Contenu de la section texte et image</h4>
            <!-- Titre de En Savoir Plus -->
            <div class="mb-3">
                <label for="faq_main_title" class="form-label">Titre en savoir plus</label>
                <input type="text" name="faq_main_title" id="faq_main_title" class="form-control"
                    value="{{ $settings['faq_main_title'] ?? '' }}">
            </div>
            
            <!-- Contenu riche pour la présentation -->
            <div class="mb-3">
                <label for="presentation_content" class="form-label">Contenu de présentation</label>
                <div id="editor">{!! $settings['presentation_content'] ?? '' !!}</div>
                <input type="hidden" name="presentation_content" id="hiddenContent">
            </div>

            <button type="submit" class="btn btn-primary">Enregistrer</button>
        </form>
    </div>
@endsection

@push('styles')
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<style>
    #editor {
        background-color: #fff;
        min-height: 200px;
        border: 1px solid #ced4da;
        border-radius: .25rem;
        padding: 10px;
    }
</style>
@endpush
@push('scripts')
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
<script>
    var quill = new Quill('#editor', {
        theme: 'snow'
    });

    // Lors de la soumission du formulaire
    document.querySelector('form').onsubmit = function () {
        document.querySelector('#hiddenContent').value = quill.root.innerHTML;
    };
</script>
@endpush
