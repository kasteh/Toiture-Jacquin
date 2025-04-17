@extends('layout.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="card shadow-sm">
        <div class="card-header bg-white border-bottom-0 py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="h5 mb-0">
                    <i class="fas fa-file-alt text-primary me-2"></i>
                    Gestion des textes
                </h2>
                <a href="{{ route('admin.contents.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus-circle me-1"></i>
                    Ajouter un texte
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
                            <th width="15%">Catégorie</th>
                            <th width="15%">Image</th>
                            <th width="20%">Titre</th>
                            <th width="40%">Contenu</th>
                            <th width="10%" class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($contents as $content)
                        <tr>
                            <td>
                                @if($content->category)
                                    <span class="badge bg-secondary">{{ $content->category->name }}</span>
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>
                            <td>
                                @if($content->image)
                                    <img src="{{ asset($content->image) }}" 
                                         alt="Image pour {{ $content->title }}" 
                                         class="img-thumbnail" 
                                         style="max-width: 80px; height: auto;">
                                @else
                                    <span class="text-muted">Aucune image</span>
                                @endif
                            </td>
                            <td>
                                <span class="fw-medium">{{ $content->title }}</span>
                            </td>
                            <td>
                                <p class="text-truncate mb-0" style="max-width: 300px;">
                                    {{ strip_tags($content->text) }}
                                </p>
                            </td>
                            <td class="text-end">
                                <div class="d-inline-flex">
                                    <a href="{{ route('admin.contents.edit', $content->slug) }}" 
                                       class="btn btn-sm btn-outline-primary me-2"
                                       title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.contents.destroy', $content->slug) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-sm btn-outline-danger"
                                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce texte ?')"
                                                title="Supprimer">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">
                                <i class="fas fa-info-circle me-2"></i>
                                Aucun texte enregistré
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($contents->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $contents->links('pagination::bootstrap-4') }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection