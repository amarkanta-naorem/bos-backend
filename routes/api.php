<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Course\CourseController;
use App\Http\Controllers\Course\CourseSectionController;
use App\Http\Controllers\Tag\TagController;
use Illuminate\Support\Facades\Route;

Route::post('auth/register', [AuthController::class, 'register']);
Route::post('auth/login', [AuthController::class, 'login']);

Route::get('course', [CourseController::class, 'index'])->middleware('throttle:api');
Route::middleware('auth:api')->group(function () {
    Route::resource('course', CourseController::class)->except('index')->middleware('throttle:api');
});

Route::get('tag', [TagController::class, 'index'])->middleware('throttle:api');
Route::middleware('auth:api')->group(function () {
    Route::resource('tag', TagController::class)->except('index')->middleware('throttle:api');
});

Route::get('course/section', [CourseSectionController::class, 'index'])->middleware('throttle:api');
Route::middleware('auth:api')->group(function () {
    Route::resource('course/section', CourseSectionController::class)->except('index')->middleware('throttle:api');
});
