<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Models\Visit;
use App\Http\Controllers\VisitController;
use App\Http\Controllers\UploadController;

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
    Route::post('/logout', [App\Http\Controllers\Auth\LogoutController::class, 'perform'])->name('logout');

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


    Route::post('/upload', [UploadController::class, 'upload'])->name('upload');

    Route::get('/visit-stats', function () {
        $data = Visit::selectRaw('country, COUNT(*) as total')
            ->groupBy('country')
            ->orderByDesc('total')
            ->get();

        return response()->json($data);
    });
    Route::post('/track-visit', [VisitController::class, 'track']);
    Route::get('/visits/total', [VisitController::class, 'getTotalVisits'])->name('visits.total');
    Route::get('/visits/this-month', [VisitController::class, 'getTotalVisitsThisMonth'])->name('visits.this-month');
    Route::get('/visits/countries-this-month', [VisitController::class, 'getVisitsByCountryThisMonth']);
    Route::get('/visits/widget-data', [VisitController::class, 'getDataForWidgetCounter'])->name('visits.widget-data');
});
