@extends('layout.admin')
@section('content')
    <form method="POST" action="/admin/categories/{{$category->slug}}">
        @csrf
        @method('PATCH')
        <h1 class="mb-5 text-md-left text-center">Modifer une catégorie</h1>
        <div class="form-group">
            <label for="categoryName" class="font-weight-bold">Nom</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="categoryName" name="name" placeholder="Nom ..." value="{{old('name') ?? $category->name}}">
            @error('name')
                <div class="text-danger"><small>{{ $message }}</small></div>
            @enderror
            @error('slug')
                <div class="text-danger"><small>{{ $message }}</small></div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Modifier</button>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-link float-right">Annuler</a>
    </form>
@endsection