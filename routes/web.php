<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/projects', function () {
    return view('projects');
})->name('projects');

Route::get('/products', function () {
    return view('products');
})->name('products');

Route::get('/about_us', function () {
    return view('about_us');
})->name('about_us');

// Admin
Route::prefix('admin')->group(function () {
    // Show login form (GET)
    Route::get('/login', [LoginController::class, 'showForm'])
        ->middleware('guest')
        ->name('admin.login.form');

    // Handle login submission (POST)
    Route::post('/login', [LoginController::class, 'submit'])
        ->name('admin.login.submit');

    // Dashboard (GET)
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});

// Handle logout submission (POST)
Route::post('/logout', [LogoutController::class, 'logout'])->name('user.logout');
