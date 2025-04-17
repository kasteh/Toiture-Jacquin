@extends('layout.admin')
@section('content')
    <form method="POST" action="/admin/users">
        @method('PATCH')
        @csrf
        <h1 class="mb-5">Modifier son mot de passe</h1>
        <div class="form-group">
            <label for="old-password" class="font-weight-bold">Mot de passe actuel</label>
            <input type="password" class="form-control @error('old_password') is-invalid @enderror" id="old-password" placeholder="Ancien mot de passe ..." name="old_password" value="{{old('old_password')}}">
            @error('old_password')
                <div class="text-danger"><small>{{ $message }}</small></div>
            @enderror
        </div>
        <div class="form-group">
            <label for="password" class="font-weight-bold">Nouveau mot de passe</label>
            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Nouveau mot de passe ..." name="password">
            @error('password')
                <div class="text-danger"><small>{{ $message }}</small></div>
            @enderror
        </div>
        <div class="form-group">
            <label for="password-confirmation" class="font-weight-bold">Confirmation du nouveau mot de passe</label>
            <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password-confirmation" placeholder="Confirmation du nouveau mot de passe ..." name="password_confirmation">
            @error('password_confirmation')
                <div class="text-danger"><small>{{ $message }}</small></div>
            @enderror
        </div>
        <button type="submit" class="btn btn-success">Créer</button>
        <a href="{{ route('admin.users.index') }}" class="btn btn-link float-right">Annuler</a>
    </form>
@endsection