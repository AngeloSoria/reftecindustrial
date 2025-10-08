<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\UserController;

Route::middleware("auth:sanctum")->group(function () {
    Route::get('/users/{perPage?}/{page?}', [UserController::class, 'getAllUsers'])->name('api.users.getAllUsers');
    Route::get('/users/{id}', [UserController::class, 'getUser'])->name('api.users.getUser');
});
Route::get('/test', [UserController::class, 'test'])->name('api.users.test');
