<?php

namespace App\Helpers;

use Illuminate\Http\Request;

class DomainHelper
{
    public static function getSubdomain(Request $request): ?string
    {
        $host = $request->getHost();
        $main = parse_url(config('app.url'), PHP_URL_HOST);
        return str_replace(".{$main}", '', $host);
    }

    public static function isSubdomain(Request $request): bool
    {
        return (bool)self::getSubdomain($request);
    }
}