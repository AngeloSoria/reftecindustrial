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

// Handle logout submission (POST)
Route::post('/logout', [LogoutController::class, 'logout'])->name('user.logout');

// Show login form (GET)
Route::get('/login', [LoginController::class, 'showForm'])
    ->middleware('guest')
    ->name('login');

// Handle login submission (POST)
Route::post('/login', [LoginController::class, 'submit'])
    ->name('login.submit');


Route::middleware(['auth'])->group(function () {
    // Dashboard (GET)
    Route::get('/dashboard', function () {
        return view('auth.dashboard');
    })->name('dashboard');

    Route::get('/my_profile', [ProfileController::class, 'show'])
        ->name('my_profile');

    Route::get('users/{id}', [ProfileController::class, 'show'])
        ->name('users.profile')
        ->where('id', '[0-9]+');

});
