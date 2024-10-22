<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BeatController;
use App\Http\Controllers\PostController;
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

Route::controller(AuthController::class)->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('login', 'login');
        Route::post('register', 'register');
    });
});

Route::middleware('auth:sanctum')->group(function () {
    Route::controller(BeatController::class)->group(function () {
        Route::prefix('beat')->group(function () {
            Route::post('store', 'create');
            Route::post('like', 'like');
        });
    });

    Route::controller(PostController::class)->group(function () {
        Route::prefix('post')->group(function () {
            Route::post('store', 'create');
            Route::post('like', 'like');
        });
    });
});