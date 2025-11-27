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
Route::view('/test', 'test')->name('test');


// Auth - Login
Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'showForm')->name('login');
    Route::post('/login', 'submit')->name('login.submit');
});

/*
|--------------------------------------------------------------------------
| Shared Content (Accessible without auth)
|--------------------------------------------------------------------------
*/
Route::prefix('content')
    ->name('content.')
    ->controller(GeneralController::class)
    ->group(function () {
        Route::get('section/hero', 'getHeroSection')->name('get.section.hero');
        Route::get('section/history', 'getHistory')->name('get.section.history');
        Route::get('section/product_lines/visible', 'getAllVisibileProductLines')->name('get.section.product_lines.visible');
        Route::get('section/about_us/gallery', 'getAllAboutUsGallery')->name('get.section.about_us.gallery');
    });

/*
|--------------------------------------------------------------------------
| Protected Routes (Authenticated Users)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // Simple static views
    $authViews = [
        'profile' => 'auth.user_profile',
        'dashboard' => 'auth.dashboard',
        'content' => 'auth.content',
        'site_monitor' => 'auth.site_monitor',
        'cartrack' => 'auth.cartrack',
        'users' => 'auth.users',
        'logs' => 'auth.logs',
        'files' => 'auth.files',
    ];

    foreach ($authViews as $route => $view) {
        Route::view("/{$route}", $view)->name($route);
    }

    // Core actions
    Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');
    Route::post('/upload', [UploadController::class, 'upload'])->name('upload');

    /*
    |--------------------------------------------------------------------------
    | Visitor Analytics
    |--------------------------------------------------------------------------
    */
    Route::prefix('visitors')
        ->name('visitors.')
        ->controller(VisitorController::class)
        ->group(function () {
            Route::get('total', 'getTotalVisitors')->name('total');
            Route::get('unique', 'getUniqueVisitors')->name('unique');
            Route::get('top-pages/{limit?}', 'getTopVisitedPages')->name('top-pages');
            Route::get('countries', 'getCountries')->name('countries');
            Route::get('os', 'getOs')->name('os');
            Route::get('devices', 'getDevices')->name('devices');
            Route::get('countries-this-month', 'getVisitsByCountryThisMonth')->name('countries-this-month');
            Route::get('widget-data', 'getDataForWidgetCounter')->name('widget-data');
        })->middleware('throttle:25,1');

    /*
    |--------------------------------------------------------------------------
    | Content Management (POST only)
    |--------------------------------------------------------------------------
    */
    Route::prefix('content')
        ->name('content.')
        ->controller(GeneralController::class)
        ->group(function () {
            Route::post('section/hero', 'setHeroSection')->name('update.section.hero');
            Route::post('section/history', 'setHistory')->name('update.section.history');

            Route::post('section/product_line/add', 'addProductLine')->name('add.section.product_line');
            Route::post('section/product_line/edit', 'setProductLine')->name('edit.section.product_line');
            Route::post('section/product_line/delete', 'deleteProductLine')->name('delete.section.product_line');
            Route::get('section/product_lines', 'getAllProductLines')->name('get.section.product_lines');

            Route::post('section/about_us/gallery/add', 'addAboutUsGalleryImage')->name('add.section.about_us.gallery');
            Route::post('section/about_us/gallery/delete', 'deleteAboutUsGallery')->name('delete.section.about_us.gallery');
            Route::post('section/about_us/gallery/edit', 'editAboutUsGallery')->name('edit.section.about_us.gallery');
            Route::post('section/about_us/gallery/update_order', 'updateOrderAboutUsGallery')->name('update.section.about_us.gallery.order');

            Route::post('section/test', 'test')->name('add.section.test');
        });
});
