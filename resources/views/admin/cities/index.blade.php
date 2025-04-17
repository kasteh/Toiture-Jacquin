@extends('layout.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="card shadow-sm">
        <div class="card-header bg-white border-bottom-0 py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="h5 mb-0">
                    <i class="fas fa-city text-primary me-2"></i>
                    Gestion des villes
                </h2>
                <a href="{{ route('admin.cities.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus-circle me-1"></i>
                    Ajouter une ville
                </a>
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

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Nom</th>
                            <th>Code</th>
                            <th>Slug</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cities as $city)
                        <tr>
                            <td>
                                <span class="fw-medium">{{ $city->name ?? 'N/A' }}</span>
                            </td>
                            <td>
                                <span class="badge">{{ $city->code }}</span>
                            </td>
                            <td>
                                <code>{{ $city->slug }}</code>
                            </td>
                            <td class="text-end">
                                <div class="d-inline-flex">
                                    <a href="{{ route('admin.cities.edit', $city->slug) }}" 
                                       class="btn btn-sm btn-outline-primary me-2"
                                       title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.cities.destroy', $city->slug) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-sm btn-outline-danger"
                                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette ville ?')"
                                                title="Supprimer">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-muted">
                                <i class="fas fa-info-circle me-2"></i>
                                Aucune ville enregistrée
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($cities->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $cities->links('pagination::bootstrap-4') }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection