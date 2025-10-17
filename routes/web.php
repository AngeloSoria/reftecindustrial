<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VisitorController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UploadController;

use App\Http\Controllers\Contents\GeneralController;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;


Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/projects', function () {
    return view('projects');
})->name('projects');

Route::get('/products', function () {
    return view('products');
})->name('products');

Route::get('/about', function () {
    return view('aboutus');
})->name('aboutus');

Route::get('/login', [LoginController::class, 'showForm'])->name('login');
Route::post('/login', [LoginController::class, 'submit'])->name('login');



Route::middleware('auth')->group(function () {
    Route::get('/profile', function () {
        return view('auth.user_profile');
    })->name('profile');
    Route::get('/dashboard', function () {
        return view('auth.dashboard');
    })->name('dashboard');
    Route::get('/content', function () {
        return view('auth.content');
    })->name('content');
    Route::get('/site_monitor', function () {
        return view('auth.site_monitor');
    })->name('site_monitor');
    Route::get('/cartrack', function () {
        return view('auth.cartrack');
    })->name('cartrack');
    Route::get('/users', function () {
        return view('auth.users');
    })->name('users');
    Route::get('/logs', function () {
        return view('auth.logs');
    })->name('logs');
    Route::get('/files', function () {
        return view('auth.files');
    })->name('files');


    Route::post('/logout', [App\Http\Controllers\Auth\LogoutController::class, 'logout'])->name('logout');
    Route::post('/upload', [UploadController::class, 'upload'])->name('upload');


    Route::group(['prefix' => 'visitors'], function () {
        Route::get('/total', [VisitorController::class, 'getTotalVisitors'])->name('visitors.total');
        Route::get('/unique', [VisitorController::class, 'getUniqueVisitors'])->name('visitors.unique');
        Route::get('/top-pages/{limit?}', [VisitorController::class, 'getTopVisitedPages'])->name('visitors.top-pages');
        Route::get('/countries', [VisitorController::class, 'getCountries'])->name('visitors.countries');
        Route::get('/os', [VisitorController::class, 'getOs'])->name('visitors.os');
        Route::get('/devices', [VisitorController::class, 'getDevices'])->name('visitors.devices');
        Route::get('/countries-this-month', [VisitorController::class, 'getVisitsByCountryThisMonth'])->name('visitors.countries-this-month');
        Route::get('/widget-data', [VisitorController::class, 'getDataForWidgetCounter'])->name('visitors.widget-data');
    });

    Route::group(['prefix' => 'content'], function () {
        Route::post('update/section/hero', [GeneralController::class, 'setHeroSection'])->name('update.content.section.hero');
    });
});
