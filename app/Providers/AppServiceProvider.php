<?php

namespace App\Providers;

use App\Setting;
use Illuminate\Support\ServiceProvider;
use App\Observers\SettingObserver;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\{Mail, Cache, Log, DB};
use App\Helpers\SettingHelper;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('path.public', function() {
            return '../public_html';
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Setting::observe(SettingObserver::class);
        View::share('siteSettings', Cache::remember('site_settings', now()->addHours(12), function() {
            return [
                'primaryColor' => SettingHelper::get('primary_color', '#FF6600'),
                'heroImage' => SettingHelper::get('hero_image', '/images/default-hero.jpg'),
            ];
        }));
    }
}
