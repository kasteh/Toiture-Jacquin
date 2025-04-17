@extends('layout.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="card shadow-lg">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h2 class="h5 mb-0">
                <i class="fas fa-robot text-primary me-2"></i>
                Interface ChatGPT
            </h2>
        </div>
        <div class="card-body">
            <div id="message-alert" class="alert d-none"></div>
            <div class="mt-4 pt-3">
                <h5 class="mb-3">Génération de contenu</h5>
                
                <form id="generation-form" class="mb-3">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="theme" class="form-label">Thème principal</label>
                            <input type="text" class="form-control" id="theme" 
                                   placeholder="Ex: Technologie, Santé, Voyage..." required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="categories-count" class="form-label">Nombre de catégories</label>
                            <input type="number" class="form-control" id="categories-count" 
                                   min="1" max="20" value="5" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="articles-count" class="form-label">Articles par catégorie</label>
                            <input type="number" class="form-control" id="articles-count" 
                                   min="1" max="20" value="5" required>
                        </div>
                    </div>
                    
                    <button type="submit" id="generate-content-btn" class="btn btn-success">
                        <i class="fas fa-magic me-2"></i>Générer le contenu
                    </button>
                </form>
                
                <div id="generation-progress" class="d-none">
                    <div class="progress mb-3">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" 
                             role="progressbar" style="width: 0%"></div>
                    </div>
                    <div class="alert alert-info">
                        <div id="progress-text">Initialisation...</div>
                        <div id="progress-details" class="small mt-1"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
document.getElementById('generation-form').addEventListener('submit', async function(e) {
    e.preventDefault();
    console.log("Le bouton de génération a été cliqué.");
    const btn = document.getElementById('generate-content-btn');
    const progressBar = document.querySelector('#generation-progress .progress-bar');
    const progressText = document.getElementById('progress-text');
    const progressDetails = document.getElementById('progress-details');
    const progressContainer = document.getElementById('generation-progress');
    
    const theme = document.getElementById('theme').value;
    const categoriesCount = document.getElementById('categories-count').value;
    const articlesCount = document.getElementById('articles-count').value;
    
    btn.disabled = true;
    progressContainer.classList.remove('d-none');
    progressBar.style.width = '0%';
    progressText.textContent = 'Démarrage de la génération...';
    progressDetails.textContent = '';
    
    try {
        const response = await fetch("{{ route('admin.chatgpt.generate-content') }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                theme: theme,
                categories_count: categoriesCount,
                articles_count: articlesCount
            })
        });
        
        const data = await response.json();
        
        if (!response.ok) {
            throw new Error(data.message || 'Erreur lors de la génération');
        }
        
        progressBar.style.width = '100%';
        progressText.textContent = 'Génération terminée avec succès !';
        progressDetails.textContent = `${data.categories} catégories et ${data.articles} articles créés sur le thème "${theme}".`;
        
        // Afficher un message global
        const alertDiv = document.getElementById('message-alert');
        alertDiv.classList.remove('d-none', 'alert-danger');
        alertDiv.classList.add('alert-success');
        alertDiv.innerHTML = `
            <strong>Génération terminée !</strong>
            <div class="mt-2">${data.categories} catégories et ${data.articles} articles créés sur le thème "${theme}".</div>
        `;
        
    } catch (error) {
        progressBar.style.width = '100%';
        progressBar.classList.remove('bg-success');
        progressBar.classList.add('bg-danger');
        progressText.textContent = 'Erreur lors de la génération';
        progressDetails.textContent = error.message;
        
        const alertDiv = document.getElementById('message-alert');
        alertDiv.classList.remove('d-none', 'alert-success');
        alertDiv.classList.add('alert-danger');
        alertDiv.textContent = error.message;
        
    } finally {
        btn.disabled = false;
    }
});
</script>
@endpush