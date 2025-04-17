@extends('layout.admin')

@section('content')
    <div class="container">
        <h2>Paramètres du site</h2>
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Champ pour la couleur principale -->
            <div class="mb-3">
                <label for="primary_color" class="form-label">Couleur principale</label>
                <input type="color" name="primary_color" id="primary_color"
                    class="form-control form-control-color"
                    value="{{ $settings['primary_color'] ?? '#4361ee' }}">
            </div>

            <!-- Champ pour l'image de fond -->
            <div class="mb-3">
                <label for="hero_image" class="form-label">Image de fond de la section héro</label>
                <input type="file" name="hero_image" id="hero_image" class="form-control" accept="image/*">
                
                <!-- Affichage de l'image actuelle (si elle existe) -->
                @if(isset($settings['hero_image']))
                    <div class="mt-2">
                        <img src="{{ asset('storage/' . $settings['hero_image']) }}" alt="Hero Image" class="img-fluid" style="max-height: 200px;">
                    </div>
                @endif
            </div>

            <button type="submit" class="btn btn-primary">Enregistrer</button>
        </form>
    </div>
@endsection
