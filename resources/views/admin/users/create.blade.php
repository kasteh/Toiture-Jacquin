@extends('layout.admin')
@section('content')
    <form method="POST" action="/admin/users" enctype="multipart/form-data">
        @csrf
        <h1 class="mb-5 text-md-left text-center">Ajouter un nouvel utilisateur</h1>
        <div class="form-group">
            <label for="userEmail" class="font-weight-bold">Adresse email</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="userEmail" name="email" placeholder="Adresse email ..." value="{{old('email')}}">
            @error('email')
                <div class="text-danger"><small>{{ $message }}</small></div>
            @enderror
        </div>
        <button type="submit" class="btn btn-success">Créer</button>
        <a href="{{ route('admin.users.index') }}" class="btn btn-link float-right">Annuler</a>
    </form>
@endsection