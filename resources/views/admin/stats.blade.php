@extends('layout.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.stats') }}">
                        <div class="row align-items-end">
                            <div class="col-md-3 col-sm-6 mb-3">
                                <div class="form-group">
                                    <label for="departementSelect" class="form-label">Département</label>
                                    <select class="form-select" id="departementSelect" onchange="updateCities()" name="departement">
                                        <option value="all">Tous les départements</option>
                                        @foreach($departements as $departement)
                                            <option value="{{ $departement->id }}" 
                                                {{ $selectedDepartement == $departement->id ? 'selected' : '' }}>
                                                {{ $departement->name }} ({{ $departement->code }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-3 col-sm-6 mb-3">
                                <div class="form-group">
                                    <label for="citySelect" class="form-label">Ville</label>
                                    <select class="form-select" id="citySelect" name="city">
                                        <option value="all">Toutes les villes</option>
                                        @if($selectedDepartement)
                                            @foreach($cities->where('departement_id', $selectedDepartement) as $city)
                                                <option value="{{ $city->id }}" 
                                                    {{ $selectedCity == $city->id ? 'selected' : '' }}>
                                                    {{ $city->name }} ({{ $city->code }})
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-4 col-sm-8 mb-3">
                                <div class="form-group">
                                    <label for="categorySelect" class="form-label">Catégorie</label>
                                    <select class="form-select" id="categorySelect" name="category">
                                        <option value="all">Toutes les catégories</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ $selectedCategory == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-2 col-sm-4 mb-3">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-filter me-1"></i> Filtrer
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-lg-6 col-md-8 col-sm-10">
            <div class="card bg-gradient-primary shadow-lg">
                <div class="card-body p-4">
                    <div class="d-flex flex-column align-items-center">
                        <h2 class="text-white mb-4">
                            <i class="fas fa-chart-line me-2"></i> Statistiques de visites
                        </h2>
                        <div class="display-2 text-white mb-3">{{ number_format($visits, 0, ',', ' ') }}</div>
                        <div class="text-white-50 fs-5">
                            <i class="fas fa-eye me-2"></i> Visites totales
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    function updateCities() {
        const departementId = document.getElementById('departementSelect').value;
        const citySelect = document.getElementById('citySelect');
        const cities = @json($cities);
        
        // Reset city select
        citySelect.innerHTML = '<option value="all">Toutes les villes</option>';
        
        if (departementId !== 'all') {
            // Filter cities by selected department
            const filteredCities = cities.filter(city => city.departement_id == departementId);
            
            // Add filtered cities to select
            filteredCities.forEach(city => {
                const option = document.createElement('option');
                option.value = city.id;
                option.textContent = `${city.name} (${city.code})`;
                citySelect.appendChild(option);
            });
        }
    }
    
    // Initialize cities on page load if department is selected
    document.addEventListener('DOMContentLoaded', function() {
        @if($selectedDepartement && $selectedDepartement !== 'all')
            updateCities();
        @endif
    });
</script>
@endsection