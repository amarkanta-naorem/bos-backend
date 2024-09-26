<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Course\CourseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::controller(AuthController::class)->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('register', 'register');
        Route::post('login', 'login');
    });
});

Route::controller(CourseController::class)->group(function () {
    Route::prefix('course')->group(function () {
        Route::get('all', 'index');
        Route::middleware('auth:api')->group(function () {
            Route::post('/', 'store');
        });
    });
});
