<?php

namespace App\Helpers;

use App\Setting;
use Illuminate\Support\Facades\Cache;

class SettingHelper
{
    protected static $cache = [];

    public static function get($key, $default = null)
    {
        if (!isset(self::$cache[$key])) {
            self::$cache[$key] = Cache::rememberForever("setting_{$key}", function() use ($key, $default) {
                return Setting::where('key', $key)->value('value') ?? $default;
            });
        }

        return self::$cache[$key];
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