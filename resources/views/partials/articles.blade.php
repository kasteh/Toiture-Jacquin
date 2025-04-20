<section class="py-5">
    <div class="container">
        <h2 class="text-center mb-5">Nos derniers articles</h2>

        <div class="row g-4">
            @foreach($contents as $key => $content)
                @php
                    $city = \App\City::where('slug', session('current_city'))->first();
                    if (!$city) {
                        $city = \App\City::inRandomOrder()->first();
                    }
                    $departement = $city?->departement ?? \App\Departement::first();

                    if (!$content->relationLoaded('category')) {
                        $content->load('category');
                    }

                    $processedText = preg_replace_callback(
                        '/\[(ville|Ville|département|Département|Departement|departement)\]/u',
                        fn($m) => str_ireplace(
                            ['ville', 'departement', 'département'],
                            [$city->name, ucfirst($departement->name), ucfirst($departement->name)],
                            $m[0]
                        ),
                        $content->text
                    );

                    $replacedTitle = preg_replace_callback(
                        '/\[(ville|Ville|département|Département|Departement|departement)\]/u',
                        fn($m) => match (strtolower($m[1])) {
                            'ville' => ucfirst($city->name),
                            'departement', 'département' => ucfirst($departement->name),
                            default => $m[0]
                        },
                        $content->title
                    );

                    $realSlug = str_replace('[ville]', $city->slug, $content->slug);

                    $contentUrl = route('content.sub.show', [
                        'city' => $city->slug,
                        'category' => $content->category,
                        'contentSlug' => $realSlug
                    ]);

                    $imageUrl = Str::start($content->image, '/');

                @endphp

                <div class="@if($key === 0) col-lg-8 @elseif($key === 1) col-lg-4 @else col-md-4 @endif">
                    <div class="card modern-card h-100 @if($key === 0) featured-article @endif">
                        <img src="{{ $imageUrl }}" class="img-fluid" style="max-height: 300px;">
                        <div class="card-body">
                            @if($key === 0)
                                <div class="badge bg-primary mb-3">Nouveau</div>
                            @endif
                            <h3 class="card-title">{{ $replacedTitle }}</h3>
                            <p class="card-text">
                                {{ Str::limit($processedText, $key === 0 ? 250 : ($key === 1 ? 120 : 100)) }}
                            </p>
                            <a href="{{ $contentUrl }}" class="btn @if($key === 0) btn-primary @else btn-outline-primary @endif stretched-link">Lire l'article</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>