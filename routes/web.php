<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    GeneralController, AgenceController, SettingController, ChatGPTController
};
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['prefix' => 'admin'], function () {
    // Authentification Admin
    Route::get('/login', 'AdminController@login')->name('admin.login');
    Route::post('/connexion', 'AdminController@connexion')->name('admin.connexion');

    Route::group(['middleware' => 'auth'], function () {
        // Dashboard & Déconnexion
        Route::get('/', 'AdminController@dashboard')->name('admin.dashboard');
        Route::get('/logout', 'AdminController@logout')->name('admin.logout');
        Route::get('/stats', 'AdminController@stats')->name('admin.stats');

        Route::get('/settings', [SettingController::class, 'edit'])->name('admin.settings.edit');
        Route::put('/settings', [SettingController::class, 'update'])->name('admin.settings.update');

        Route::resource('/categories', CategoryController::class, ['as' => 'admin']);

        Route::resource('/contents', ContentController::class, ['as' => 'admin']);

        Route::resource('/users', UserController::class, ['as' => 'admin']);

        Route::resource('/departements', DepartementController::class, ['as' => 'admin']);

        Route::resource('/cities', CityController::class, ['as'=> 'admin']);

        // Routes ChatGPT
        Route::get('/chatgpt', [ChatGPTController::class,'index'])->name('admin.chatgpt');
        Route::post('/chatgpt/process', [ChatGPTController::class, 'process'])->name('admin.chatgpt.process');
        Route::post('/chatgpt/generate-content', [ChatGPTController::class, 'generateContent'])->name('admin.chatgpt.generate-content');
        //Route::get('/chatgpt', 'ChatGPTController@index')->name('admin.chatgpt');
        // Route::post('/chatgpt/process', 'ChatGPTController@process')->name('admin.chatgpt.process');
        // Route::post('/chatgpt/generate-content', 'ChatGPTController@generateContent')->name('admin.chatgpt.generate-content');
    });
});

// Domaine principal
Route::domain(parse_url(config('app.url'), PHP_URL_HOST))
    ->middleware('forget.city')
    ->group(function () {
    Route::get('/', [GeneralController::class, 'index']);
    Route::get('/nos-agences', [AgenceController::class, 'index'])->name('nos-agences');
    Route::get('/devenir-partenaire', [AgenceController::class, 'create'])->name('devenir-partenaire');
    Route::post('/devenir-partenaire', [AgenceController::class, 'store'])->name('partenaire');
    Route::post('/contact', [GeneralController::class, 'contact'])->name('contact');
    Route::post('/phone', [GeneralController::class, 'phone'])->name('phone');
    Route::get('/mentions-legales', [GeneralController::class, 'mentionsLegales'])->name('mentions-legales');
    Route::get('/api/cities', [GeneralController::class, 'getAllCities']);
});

// Préparation des routes 
$host = parse_url(config('app.url'), PHP_URL_HOST);
$subdomainPattern = app()->environment('production') 
    ? '{city}.' . $host 
    : '{city}.localhost';

// Sous-domaine du contenu
Route::domain('{contentSlug}.' . $host)->group(function () {
    Route::get('/{city}/{category}', [GeneralController::class, 'showTextFromSubdomain'])
        ->name('content.sub.show')
        ->where([
            'city' => '[a-z0-9-]+',
            'category' => '[a-z0-9-]+'
        ]);
});

// Routes avec SOUS-DOMAINE de ville — PAS DE SHOWTEXT ICI
Route::domain($subdomainPattern)
    ->middleware('detect.city')
    ->group(function () {
        Route::get('/', [GeneralController::class, 'cityIndex'])
            ->name('city.index')
            ->where('city', '[a-z0-9-]+');

        Route::get('/{category}', [GeneralController::class, 'show'])
            ->name('category.show')
            ->where('category', '[a-z0-9-]+');
    });

