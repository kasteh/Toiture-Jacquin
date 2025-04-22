<?php

namespace App\Helpers;

use App\Setting;
use Illuminate\Support\Facades\Cache;

class SettingHelper
{
    protected static $cache = [];

    public static function get($key, $default = null)
    {
        $version = Cache::rememberForever('settings_version', function () {
            return now()->timestamp;
        });
    
        $cacheKey = "setting_{$key}_v{$version}";
    
        if (!isset(self::$cache[$cacheKey])) {
            self::$cache[$cacheKey] = Cache::rememberForever($cacheKey, function () use ($key, $default) {
                return Setting::where('key', $key)->value('value') ?? $default;
            });
        }
    
        return self::$cache[$cacheKey];
    }
    
    public static function invalidateVersion()
    {
        Cache::forget('settings_version');
    }

    public static function clearCache($key = null)
    {
        if ($key) {
            Cache::forget("setting_{$key}");
            unset(self::$cache[$key]);
        } else {
            foreach (array_keys(self::$cache) as $k) {
                Cache::forget("setting_{$k}");
            }
            self::$cache = [];
        }
    }
}