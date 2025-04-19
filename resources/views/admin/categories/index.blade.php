@extends('layout.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="card shadow-sm">
        <div class="card-header bg-white border-bottom-0 py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="h5 mb-0">
                    <i class="fas fa-folder-open text-primary me-2"></i>
                    Liste des catégories
                </h2>
                <div class="d-flex align-items-center">
                    <form id="bulk-delete-form" action="{{ route('admin.categories.bulk-delete') }}" method="POST" class="me-2">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="ids" id="selected-ids">
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer les catégories sélectionnées ?')">
                            <i class="fas fa-trash-alt me-1"></i>
                            Supprimer la sélection
                        </button>
                    </form>
                    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus-circle me-1"></i>
                        Ajouter une catégorie
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form id="category-table-form">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th width="5%">
                                    <input type="checkbox" id="select-all">
                                </th>
                                <th width="65%">Nom</th>
                                <th width="30%" class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categories as $category)
                            <tr>
                                <td>
                                    <input type="checkbox" class="category-checkbox" value="{{ $category->id }}">
                                </td>
                                <td>
                                    <span class="fw-medium">{{ $category->name }}</span>
                                    @if($category->description)
                                        <p class="text-muted small mb-0">{{ Str::limit($category->description, 50) }}</p>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <div class="d-inline-flex">
                                        <a href="{{ route('admin.categories.edit', $category->slug) }}" 
                                           class="btn btn-sm btn-outline-primary me-2"
                                           title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.categories.destroy', $category->slug) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-sm btn-outline-danger"
                                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ?')"
                                                    title="Supprimer">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center py-4 text-muted">
                                    Aucune catégorie disponible
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </form>

            @if($categories->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $categories->links('pagination::bootstrap-4') }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Tout sélectionner
    document.getElementById('select-all').addEventListener('change', function() {
        const checked = this.checked;
        document.querySelectorAll('.category-checkbox').forEach(cb => cb.checked = checked);
    });

    // Soumission du formulaire
    document.getElementById('bulk-delete-form').addEventListener('submit', function(e) {
        const selected = Array.from(document.querySelectorAll('.category-checkbox:checked'))
                              .map(cb => cb.value);

        if (selected.length === 0) {
            e.preventDefault();
            alert('Veuillez sélectionner au moins une catégorie.');
            return;
        }

        document.getElementById('selected-ids').value = selected.join(',');
    });
</script>
@endpush
