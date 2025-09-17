<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/sample', function () {
    return view('sample');
});

// Temporary route for home view
Route::get('/welcome', function () {
    return view('welcome');
});