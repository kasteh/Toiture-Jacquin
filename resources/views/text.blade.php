@extends('layout.app')

@section('meta')
    <title>{{ config('app.startup') . ' | ' . $category->name . ', ' . $city->name }}</title>
@endsection

@section('content')
    @php
        // Simplified text replacement - removed department reference
        $processedText = preg_replace_callback(
            '/\[(ville|Ville|département|Département|Departement|departement)\]/u',
            function ($matches) use ($city, $departement) {
                $keyword = strtolower($matches[1]);
                $isCapital = mb_substr($matches[1], 0, 1) === mb_strtoupper(mb_substr($matches[1], 0, 1));
                
                $replacement = match($keyword) {
                    'ville' => $city->name,
                    'département', 'departement' => $departement->name,
                    default => '',
                };
                
                return $isCapital ? ucfirst($replacement) : lcfirst($replacement);
            },
            $content->text
        );
        
        $contentUrl = route('content.sub.show', [
            'city' => $city->slug,
            'category' => $category->slug,
            'contentSlug' => $content->slug
        ]);
        
        $imageUrl = Str::start($content->image, '/');
    @endphp
    @php
        $replacedTitle = preg_replace_callback(
            '/\[(ville|Ville|département|Département|Departement|departement)\]/u',
            function ($matches) use ($city, $departement) {
                $keyword = strtolower($matches[1]);
    
                $replacement = match($keyword) {
                    'ville' => $city->name,
                    'département', 'departement' => $departement->name,
                    default => '',
                };
    
                // Toujours retour avec majuscule pour nom propre
                return ucfirst($replacement);
            },
            $content->title
        );
    @endphp

    <div class="container my-4">
        <div class="bg-white p-4 rounded shadow-sm">
            <div class="row">
                <!-- Image Section -->
                <div class="col-12 mb-3 d-flex justify-content-center">
                    <img src="{{ asset($content->image) }}" alt="Image de {{ $category->name }}" class="img-fluid rounded">
                </div>
                
                <!-- Content Section -->
                <div class="col-12">
                    <h4 class="text-center font-weight-bold text-primary my-3">{{ $replacedTitle }}</h4>
                    <p class="text-justify mb-0">{!! nl2br(e($processedText)) !!}</p>
                    <p class="mt-3 text-center">
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
