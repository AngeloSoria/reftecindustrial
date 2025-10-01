<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\UserController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// Route::middleware('auth:sanctum')->group(function () {
//     Route::get('/users', [UserController::class, 'index']);
//     Route::get('/users/{id}', [UserController::class, 'show']);
// });


Route::get('/users/{perPage?}/{page?}', [UserController::class, 'getAllUsers'])->name('api.users.getAllUsers');
Route::get('/user/{id}', [UserController::class, 'getUser'])->name('api.users.getUser');
Route::get('/test', [UserController::class, 'test'])->name('api.users.test');
