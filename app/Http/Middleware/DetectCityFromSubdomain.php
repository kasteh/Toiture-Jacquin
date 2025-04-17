<?php

namespace App\Http\Middleware;

use Closure;
use App\City;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class DetectCityFromSubdomain
{
    public function handle(Request $request, Closure $next)
    {
        $city = $this->resolveCityFromRequest($request);

        // Enregistrement en session et dans l'objet request
        Session::put('current_city', $city?->slug);
        $request->attributes->set('currentCity', $city);

        return $next($request);
    }

    /**
     * Résout la ville depuis le sous-domaine
     */
    protected function resolveCityFromRequest(Request $request): ?City
    {
        $subdomain = $this->extractSubdomain($request->getHost());

        if (empty($subdomain) || $subdomain === 'www') {
            return null;
        }

        return Cache::remember("city_{$subdomain}", now()->addHour(), function () use ($subdomain) {
            return City::where('slug', $subdomain)->first();
        });
    }

    /**
     * Extrait le sous-domaine depuis l'hôte (city.localhost)
     */
    protected function extractSubdomain(string $host): ?string
    {
        $mainHost = parse_url(config('app.url'), PHP_URL_HOST);

        if (!str_ends_with($host, $mainHost)) {
            return null;
        }

        $sub = str_replace(".{$mainHost}", '', $host);

        return $sub !== $host ? $sub : null;
    }
}
