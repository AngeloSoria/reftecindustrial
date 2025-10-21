<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\{LoginController, LogoutController};
use App\Http\Controllers\{VisitorController, UploadController};
use App\Http\Controllers\Contents\GeneralController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::view('/', 'home')->name('home');
Route::view('/projects', 'projects')->name('projects');
Route::view('/products', 'products')->name('products');
Route::view('/about', 'aboutus')->name('aboutus');

Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'showForm')->name('login');
    Route::post('/login', 'submit')->name('login.submit');
});

/*
|--------------------------------------------------------------------------
| Protected Routes (Authenticated Users)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // Simple view-only pages
    Route::view('/profile', 'auth.user_profile')->name('profile');
    Route::view('/dashboard', 'auth.dashboard')->name('dashboard');
    Route::view('/content', 'auth.content')->name('content');
    Route::view('/site_monitor', 'auth.site_monitor')->name('site_monitor');
    Route::view('/cartrack', 'auth.cartrack')->name('cartrack');
    Route::view('/users', 'auth.users')->name('users');
    Route::view('/logs', 'auth.logs')->name('logs');
    Route::view('/files', 'auth.files')->name('files');

    // Controllers
    Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');
    Route::post('/upload', [UploadController::class, 'upload'])->name('upload');

    /*
    |--------------------------------------------------------------------------
    | Visitor Analytics Routes
    |--------------------------------------------------------------------------
    */
    Route::prefix('visitors')->name('visitors.')->controller(VisitorController::class)->group(function () {
        Route::get('/total', 'getTotalVisitors')->name('total');
        Route::get('/unique', 'getUniqueVisitors')->name('unique');
        Route::get('/top-pages/{limit?}', 'getTopVisitedPages')->name('top-pages');
        Route::get('/countries', 'getCountries')->name('countries');
        Route::get('/os', 'getOs')->name('os');
        Route::get('/devices', 'getDevices')->name('devices');
        Route::get('/countries-this-month', 'getVisitsByCountryThisMonth')->name('countries-this-month');
        Route::get('/widget-data', 'getDataForWidgetCounter')->name('widget-data');
    });

    /*
    |--------------------------------------------------------------------------
    | Content Management Routes
    |--------------------------------------------------------------------------
    */
    Route::prefix('content')->name('content.')->controller(GeneralController::class)->group(function () {
        // POST
        Route::post('section/hero', 'setHeroSection')->name('update.section.hero');
        Route::post('section/history', 'setHistory')->name('update.section.history');
    });
});
Route::prefix('content')->name('content.')->controller(GeneralController::class)->group(function () {
    // GET
    Route::get('section/hero', 'getHeroSection')->name('get.section.hero');
    Route::get('section/history', 'getHistory')->name('get.section.history');
});
