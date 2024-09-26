<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Course\CourseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('register', 'register');
        Route::post('login', 'login');
    });
});

Route::prefix('course')->group(function () {
    Route::get('/', [CourseController::class, 'index'])->middleware('throttle:api');;
    Route::middleware('auth:api')->group(function () {
        Route::resource('/', CourseController::class)->except('index')->middleware('throttle:api');;
    });
});
