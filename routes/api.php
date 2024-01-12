<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::middleware('guest')->group(function () {
    Route::post('register', [\App\Http\Controllers\AuthController::class, 'register']);
    Route::post('login', [\App\Http\Controllers\AuthController::class, 'login']);
});

Route::middleware('auth:api')->group(function () {
    Route::get('profile', [\App\Http\Controllers\AuthController::class, 'getProfile']);
    Route::prefix('user')->group(function () {
        Route::get('', [\App\Http\Controllers\UserController::class, 'index']);
        Route::get('/{id}', [\App\Http\Controllers\UserController::class, 'item']);
        Route::delete('/{id}', [\App\Http\Controllers\UserController::class, 'delete']);
        Route::post('/{id}/update', [\App\Http\Controllers\UserController::class, 'update']);
    });
});

