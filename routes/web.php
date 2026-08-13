<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PlacesController;
use App\Http\Controllers\MapImageController;
use App\Http\Controllers\SolarDesignController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('dashboard');
});

/*
|--------------------------------------------------------------------------
| Protected Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */

   Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth','verified'])
    ->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | Properties
    |--------------------------------------------------------------------------
    */

   Route::middleware(['auth'])->group(function () {

        Route::resource('properties', PropertyController::class);

    });

    /*
    |--------------------------------------------------------------------------
    | Maps
    |--------------------------------------------------------------------------
    */

    Route::view('/maps', 'maps.index')
        ->name('maps');

    // Address autocomplete + satellite preview, proxied so the Google API key
    // is never exposed to the browser.
    Route::get('/places/autocomplete', [PlacesController::class, 'autocomplete'])
        ->middleware('throttle:60,1')
        ->name('places.autocomplete');

    Route::get('/places/details', [PlacesController::class, 'details'])
        ->middleware('throttle:60,1')
        ->name('places.details');

    Route::get('/map-image', MapImageController::class)
        ->middleware('throttle:120,1')
        ->name('map.image');

    /*
    |--------------------------------------------------------------------------
    | Solar Designer
    |--------------------------------------------------------------------------
    */

    Route::get('/solar', [SolarDesignController::class, 'index'])
        ->name('solar');

    Route::get('/solar/{property}', [SolarDesignController::class, 'design'])
        ->name('solar.design');

    Route::post('/solar/{property}', [SolarDesignController::class, 'store'])
        ->name('solar.design.store');

    /*
    |--------------------------------------------------------------------------
    | Reports
    |--------------------------------------------------------------------------
    */

    Route::view('/reports', 'reports.index')
        ->name('reports');

    /*
    |--------------------------------------------------------------------------
    | AI Assistant
    |--------------------------------------------------------------------------
    */

    Route::view('/ai', 'ai.index')
        ->name('ai');

    /*
    |--------------------------------------------------------------------------
    | Billing
    |--------------------------------------------------------------------------
    */

    Route::view('/billing', 'billing.index')
        ->name('billing');

    /*
    |--------------------------------------------------------------------------
    | Settings
    |--------------------------------------------------------------------------
    */

    Route::view('/settings', 'settings.index')
        ->name('settings');

    /*
    |--------------------------------------------------------------------------
    | Profile
    |--------------------------------------------------------------------------
    */

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

});

require __DIR__.'/auth.php';