<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Course\CourseController;
use App\Http\Controllers\Course\CourseSectionContentController;
use App\Http\Controllers\Course\CourseSectionController;
use App\Http\Controllers\Tag\TagController;
use Illuminate\Support\Facades\Route;

Route::post('auth/register', [AuthController::class, 'register']);
Route::post('auth/login', [AuthController::class, 'login']);

Route::prefix('course')->group(function () {
    Route::get('/', [CourseController::class, 'index'])->middleware('throttle:api');
    Route::middleware('auth:api')->group(function () {
        Route::resource('/', CourseController::class)->except('index')->middleware('throttle:api');
    });

    Route::prefix('section')->group(function () {
        Route::get('/', [CourseSectionController::class, 'index'])->middleware('throttle:api');
        Route::middleware('auth:api')->group(function () {
            Route::resource('/', CourseSectionController::class)->except('index')->middleware('throttle:api');
        });

        Route::prefix('content')->group(function () {
            Route::get('/', [CourseSectionContentController::class, 'index'])->middleware('throttle:api');
            Route::middleware('auth:api')->group(function () {
                Route::resource('/', CourseSectionContentController::class)->except('index')->middleware('throttle:api');
            });
        });
    });
});


Route::get('tag', [TagController::class, 'index'])->middleware('throttle:api');
Route::middleware('auth:api')->group(function () {
    Route::resource('tag', TagController::class)->except('index')->middleware('throttle:api');
});
