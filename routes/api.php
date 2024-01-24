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
    Route::prefix('test/user-test')->group(function () {
//        Route::get('/{id}', [\App\Http\Controllers\UserTestController::class, 'index']);
        Route::post('', [\App\Http\Controllers\UserTestController::class, 'store']);
        Route::post('/{id}/set-answer', [\App\Http\Controllers\UserTestController::class, 'setAnswer']);
        Route::get('/{id}/questions', [\App\Http\Controllers\UserTestController::class, 'questions']);
    });
});

Route::middleware('auth:api')->group(function () {
    Route::get('profile', [\App\Http\Controllers\AuthController::class, 'getProfile']);
    Route::prefix('user')->group(function () {
        Route::get('', [\App\Http\Controllers\UserController::class, 'index']);
        Route::get('/{id}', [\App\Http\Controllers\UserController::class, 'item']);
        Route::delete('/{id}', [\App\Http\Controllers\UserController::class, 'delete']);
        Route::post('/{id}/update', [\App\Http\Controllers\UserController::class, 'update']);
    });

    Route::prefix('test')->group(function () {
        Route::prefix('/application')->group(function () {
            Route::get('', [\App\Http\Controllers\TestApplicationController::class, 'index']);
            Route::post('', [\App\Http\Controllers\TestApplicationController::class, 'store']);
            Route::delete('/{id}', [\App\Http\Controllers\TestApplicationController::class, 'delete']);
        });
        Route::get('', [\App\Http\Controllers\TestController::class, 'index']);
        Route::post('', [\App\Http\Controllers\TestController::class, 'store']);
        Route::post('/{id}/update', [\App\Http\Controllers\TestController::class, 'update']);
        Route::delete('/{id}', [\App\Http\Controllers\TestController::class, 'delete']);
        Route::get('/{id}', [\App\Http\Controllers\TestController::class, 'item']);
        Route::prefix('/{test_id}/questions')->group(function () {
            Route::get('', [\App\Http\Controllers\TestQuestionController::class, 'index']);
            Route::get('/{id}', [\App\Http\Controllers\TestQuestionController::class, 'item']);
            Route::post('', [\App\Http\Controllers\TestQuestionController::class, 'store']);
            Route::post('/{id}/update', [\App\Http\Controllers\TestQuestionController::class, 'update']);
        });

        Route::prefix('/user-test')->group(function () {
            Route::get('/{id}', [\App\Http\Controllers\UserTestController::class, 'index']);
//            Route::post('', [\App\Http\Controllers\UserTestController::class, 'store']);
//            Route::post('/{id}/set-answer', [\App\Http\Controllers\UserTestController::class, 'setAnswer']);
//            Route::get('/{id}/questions', [\App\Http\Controllers\UserTestController::class, 'questions']);
        });
    });
    Route::post('applications', [\App\Http\Controllers\ApplicationController::class, 'store']);
    Route::get('applications', [\App\Http\Controllers\ApplicationController::class, 'index']);
});

