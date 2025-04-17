@extends('layout.admin')

@section('content')
    <h1 class="mb-5 text-md-left text-center">Modifier l'image</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.contents.updateImage', $content->slug) }}" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        <div class="form-group">
            <label for="contentImage" class="font-weight-bold">Image</label>

            @if($content->image)
                <div class="mb-3">
                    <img src="{{ asset('storage/' . $content->image) }}" alt="Site couvreur" class="img-thumbnail" width="200">
                </div>
            @endif

            <input type="file" class="form-control-file @error('image') is-invalid @enderror" id="contentImage" name="image" accept="image/*">

            @error('image')
                <div class="text-danger"><small>{{ $message }}</small></div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success">Modifier</button>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-link float-right">Annuler</a>
    </form>
@endsection
