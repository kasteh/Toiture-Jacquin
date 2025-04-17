@extends('layout.admin')
@section('content')
    <form method="POST" action="{{ route('admin.departements.update', $departement->slug) }}" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <h1 class="mb-5 text-md-left text-center">Modifier le Département</h1>

        {{-- Code Field --}}
        <div class="form-group">
            <label for="departementCode" class="font-weight-bold">Code</label>
            <input type="text" 
                   class="form-control @error('code') is-invalid @enderror" 
                   id="departementCode" 
                   name="code" 
                   placeholder="Code ..." 
                   value="{{ old('code', $departement->code) }}">
            @error('code')
                <div class="text-danger"><small>{{ $message }}</small></div>
            @enderror
        </div>

        {{-- Name Field --}}
        <div class="form-group">
            <label for="departementName" class="font-weight-bold">Nom</label>
            <input type="text" 
                   class="form-control @error('name') is-invalid @enderror" 
                   id="departementName" 
                   name="name" 
                   placeholder="Nom ..." 
                   value="{{ old('name', $departement->name) }}">
            @error('name')
                <div class="text-danger"><small>{{ $message }}</small></div>
            @enderror
        </div>

        {{-- Slug Field --}}
        <div class="form-group">
            <label for="departementSlug" class="font-weight-bold">Slug</label>
            <input type="text" 
                   class="form-control @error('slug') is-invalid @enderror" 
                   id="departementSlug" 
                   name="slug" 
                   placeholder="Slug ..." 
                   value="{{ old('slug', $departement->slug) }}">
            @error('slug')
                <div class="text-danger"><small>{{ $message }}</small></div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success">Modifier</button>
        <a href="{{ route('admin.departements.index') }}" class="btn btn-link float-right">Annuler</a>
    </form>
@endsection
