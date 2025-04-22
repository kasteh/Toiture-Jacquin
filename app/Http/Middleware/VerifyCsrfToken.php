<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        //
    ];

    protected function addCookieToResponse($request, $response)
    {
        $response = parent::addCookieToResponse($request, $response);
        
        if ($request->routeIs('admin.connexion')) {
            $response->headers->set('X-CSRF-Token', csrf_token());
        }
        
        return $response;
    }
}
