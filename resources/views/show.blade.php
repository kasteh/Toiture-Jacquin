@extends('layout.app')

@section('meta')
    <title>{{ config('app.startup') }} | {{ $category->name }} - {{ $city->name }}</title>
    <meta name="description" content="Découvrez nos services de {{ $category->name }} à {{ $city->name }}. Professionnels qualifiés pour tous vos besoins en {{ $category->name }}.">
@endsection

@push('styles')
<style>
    .content-item:hover {
        transform: translateY(-3px);
        transition: all 0.3s ease-in-out;
    }

    .content-title a {
        color: inherit;
        text-decoration: none;
    }

    .content-title a:hover {
        color: #0d6efd;
    }

    /* Section CTA */
    .cta-section {
        background: {{ App\Setting::get('primary_color', '#4361ee') }}; 
        position: relative;
        overflow: hidden;
    }

    .cta-section::before {
        content: '';
        position: absolute;
        top: -50px;
        right: -50px;
        width: 200px;
        height: 200px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }

    .cta-section::after {
        content: '';
        position: absolute;
        bottom: -80px;
        left: -80px;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 50%;
    }

    .cta-card {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        position: relative;
        z-index: 1;
    }
</style>
@endpush

@section('content')
<div class="container py-4">
    <div class="bg-white p-4 p-md-5 rounded shadow-sm">
        @foreach($category->contents as $key => $content)
            @php
                // Remplacer les placeholders dans le texte
                $processedText = preg_replace_callback(
                    '/\[(ville|Ville|département|Département|Departement|departement)\]/u',
                    fn($m) => str_ireplace(
                        ['ville', 'departement', 'département'],
                        [$city->name, ucfirst($departement->name), ucfirst($departement->name)],
                        $m[0]
                    ),
                    $content->text
                );

                // Remplacer les placeholders dans le titre
                $replacedTitle = preg_replace_callback(
                    '/\[(ville|Ville|département|Département|Departement|departement)\]/u',
                    fn($m) => match (strtolower($m[1])) {
                        'ville' => ucfirst($city->name),
                        'departement', 'département' => ucfirst($departement->name),
                        default => $m[0]
                    },
                    $content->title
                );

                // Générer l'URL de contenu avec la ville
                $parsedUrl = parse_url(config('app.url'));
                $host = $parsedUrl['host'] ?? 'localhost';
                $port = isset($parsedUrl['port']) ? ':' . $parsedUrl['port'] : '';
                $scheme = $parsedUrl['scheme'] ?? 'http';

                $slugWithCity = str_replace('[ville]', strtolower($city->slug), $content->slug);
                $contentUrl = $scheme . '://' . $slugWithCity . '.' . $host . $port . '/' . strtolower($city->slug) . '/' . $category->slug;
                
                // Traiter l'image
                $imageUrl = Str::start($content->image, '/');
            @endphp

            <div class="content-item mb-5 pb-4 border-bottom">
                <div class="row g-4 align-items-center">
                    <div class="{{ $key === 0 ? 'col-lg-6' : 'col-md-4' }}">
                        <a href="{{ $contentUrl }}">
                            <div class="ratio ratio-16x9 rounded overflow-hidden">
                                <div style="background-image: url('{{ $imageUrl }}'); background-size: cover; background-position: center;"></div>
                            </div>
                        </a>
                    </div>

                    <div class="{{ $key === 0 ? 'col-lg-6' : 'col-md-8' }}">
                        <h2 class="content-title h4 fw-bold mb-3">
                            <a href="{{ $contentUrl }}">{{ $replacedTitle }}</a>
                        </h2>
                        <p class="text-muted mb-0">
                            {{ Str::limit($processedText, 300) }}
                            @if (strlen($processedText) > 300)
                                <a href="{{ $contentUrl }}" class="text-primary text-decoration-none">Lire la suite</a>
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            {{-- Insertion CTA après chaque 3 contenus si total > 3 --}}
            @if($loop->iteration % 3 === 0 && $category->contents->count() > 3)
                @include('partials.cta')
            @endif
        @endforeach
    </div>
</div>
@endsection