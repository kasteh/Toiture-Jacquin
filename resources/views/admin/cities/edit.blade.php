@extends('layout.admin')
@section('content')
    <form method="POST" action="{{ route('admin.cities.update', $city->slug) }}" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <h1 class="mb-5 text-md-left text-center">Modifier la ville</h1>

        <div class="form-group">
            <label for="contentDepartement" class="font-weight-bold">Departement</label>
            <select class="form-control @error('departement_code') is-invalid @enderror" id="contentDepartement" name="departement_code">
                <option value="">Sélectionner un département</option>
                @foreach($departements as $departement)
                    <option value="{{ $departement->id }}" 
                        {{ old("departement_code", $city->departement_code) == $departement->id ? "selected" : "" }}>
                        {{ $departement->name }}
                    </option>
                @endforeach
            </select>
            @error('departement_code')
                <div class="text-danger"><small>{{ $message }}</small></div>
            @enderror
        </div>

        <div class="form-group">
            <label for="citySlug" class="font-weight-bold">Slug</label>
            <input type="text" class="form-control @error('slug') is-invalid @enderror" id="citySlug" name="slug" placeholder="Slug ..." value="{{ old('slug', $city->slug) }}">
            @error('slug')
                <div class="text-danger"><small>{{ $message }}</small></div>
            @enderror
        </div>

        <div class="form-group">
            <label for="cityNamesimple" class="font-weight-bold">Nom Simple</label>
            <input type="text" class="form-control @error('name_simple') is-invalid @enderror" id="cityNamesimple" name="name_simple" placeholder="Nom Simple ..." value="{{ old('name', $city->name_simple) }}">
            @error('name_simple')
                <div class="text-danger"><small>{{ $message }}</small></div>
            @enderror
        </div>

        <div class="form-group">
            <label for="citytName" class="font-weight-bold">Nom</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="citytName" name="name" placeholder="Nom ..." value="{{ old('name', $city->name) }}">
            @error('name')
                <div class="text-danger"><small>{{ $message }}</small></div>
            @enderror
        </div>

        <div class="form-group">
            <label for="cityCode" class="font-weight-bold">Slug</label>
            <input type="text" class="form-control @error('code') is-invalid @enderror" id="cityCode" name="code" placeholder="Code ..." value="{{ old('code', $city->code) }}">
            @error('code')
                <div class="text-danger"><small>{{ $message }}</small></div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success">Modifier</button>
        <a href="{{ route('admin.contents.index') }}" class="btn btn-link float-right">Annuler</a>
    </form>
@endsection
