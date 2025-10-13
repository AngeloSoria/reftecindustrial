<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

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

    Route::get('/dashboard', function () {
        return view('auth.dashboard');
    })->name('dashboard');

    Route::get('/profile', function () {
        return view('auth.user_profile');
    })->name('profile');


});
