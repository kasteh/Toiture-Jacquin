@extends('layout.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="card shadow-sm">
        <div class="card-header bg-white border-bottom-0 py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="h5 mb-0">
                    <i class="fas fa-globe-europe text-primary me-2"></i>
                    Gestion des départements
                </h2>
                <a href="{{ route('admin.departements.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus-circle me-1"></i>
                    Ajouter un département
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
                            <th width="15%">Code</th>
                            <th width="35%">Nom</th>
                            <th width="30%">Slug</th>
                            <th width="20%" class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($departements as $departement)
                        <tr>
                            <td>
                                <span class="badge">{{ $departement->code ?? 'N/A' }}</span>
                            </td>
                            <td>
                                <span class="fw-medium">{{ $departement->name ?? 'N/A' }}</span>
                            </td>
                            <td>
                                <code>{{ $departement->slug }}</code>
                            </td>
                            <td class="text-end">
                                <div class="d-inline-flex">
                                    <a href="{{ route('admin.departements.edit', $departement->slug) }}" 
                                       class="btn btn-sm btn-outline-primary me-2"
                                       title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.departements.destroy', $departement->slug) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-sm btn-outline-danger"
                                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce département ?')"
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
                                Aucun département enregistré
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($departements->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $departements->links('pagination::bootstrap-4') }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection