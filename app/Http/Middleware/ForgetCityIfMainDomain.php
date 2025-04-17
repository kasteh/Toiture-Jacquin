<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class ForgetCityIfMainDomain
{
    public function handle(Request $request, Closure $next)
    {
        $host = $request->getHost();
        $mainHost = parse_url(config('app.url'), PHP_URL_HOST);

        if ($host === $mainHost || $host === "www.{$mainHost}") {
            Session::forget('current_city');
        }

        return $next($request);
    }
}
