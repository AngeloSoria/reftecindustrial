<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Admin\ProfileController;


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

    // FIXME: Make the route become auth only access.
    // Dashboard (GET)
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard')->middleware('auth');

    Route::get('/profile/{id?}', [ProfileController::class, 'show'])
        ->where('id', '[0-9]+') // optional but safer
        ->name('admin.profile');
});

// Handle logout submission (POST)
Route::post('/logout', [LogoutController::class, 'logout'])->name('user.logout');
