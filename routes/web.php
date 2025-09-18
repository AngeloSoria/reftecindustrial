<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/sample', function () {
    return view('sample');
});

// Temporary route for home view
Route::get('/welcome', function () {
    return view('welcome');
});