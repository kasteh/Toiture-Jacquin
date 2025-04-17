@extends('layout.admin')
@section('content')
    <form method="POST" action="{{ route('admin.contents.update', $content->slug) }}" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <h1 class="mb-5 text-md-left text-center">Modifier le texte</h1>

        <div class="form-group">
            <label for="contentCategory" class="font-weight-bold">Categorie</label>
            <select class="form-control @error('category_id') is-invalid @enderror" id="contentCategory" name="category_id">
                <option value="">Sélectionner une catégorie</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" 
                        {{ old('category_id', $content->category_id) == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id')
                <div class="text-danger"><small>{{ $message }}</small></div>
            @enderror
        </div>

        <div class="form-group">
            <label for="contentTitle" class="font-weight-bold">Titre</label>
            <input type="text" class="form-control @error('title') is-invalid @enderror" id="contentTitle" name="title" placeholder="Titre ..." value="{{ old('title', $content->title) }}">
            @error('title')
                <div class="text-danger"><small>{{ $message }}</small></div>
            @enderror
        </div>

        <div class="form-group">
            <label for="contentText" class="font-weight-bold">Texte</label>
            <div class="mb-3"><small><em>Veuillez remplacer les noms des villes par <strong>[ville]</strong> et le nom des départements par <strong>[departement]</strong>, et ils seront ensuite automatiquement remplacés.</em></small></div>
            <textarea class="form-control @error('text') is-invalid @enderror" id="contentText" rows="3" name="text" placeholder="Texte ...">{{ old('text', $content->text) }}</textarea>
            @error('text')
                <div class="text-danger"><small>{{ $message }}</small></div>
            @enderror
        </div>

        <div class="form-group">
            <label for="contentImage" class="font-weight-bold">Image</label>
            
            @if($content->image)
                <div class="mb-3">
                    <img src="{{ asset($content->image) }}" alt="Image de {{ $content->title }}" class="img-thumbnail" width="200">
                </div>
            @endif

            <input type="file" class="form-control-file @error('image') is-invalid @enderror" id="contentImage" name="image" accept="image/*">
            @error('image')
                <div class="text-danger"><small>{{ $message }}</small></div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success">Modifier</button>
        <a href="{{ route('admin.contents.index') }}" class="btn btn-link float-right">Annuler</a>
    </form>
@endsection
