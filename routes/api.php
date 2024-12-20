<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('auth', [AuthController::class, 'auth']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::middleware('isAdmin')->group(function () {
        Route::apiResource('roles', \App\Http\Controllers\RoleController::class);
        Route::get('users', [\App\Http\Controllers\UserController::class, 'index']);
        Route::post('users', [\App\Http\Controllers\UserController::class, 'store']);
        Route::get('users/{id}', [\App\Http\Controllers\UserController::class, 'show']);
        Route::put('users/{id}', [\App\Http\Controllers\UserController::class, 'update']);
        Route::delete('users/{id}', [\App\Http\Controllers\UserController::class, 'destroy']);

    });
    Route::apiResource('hotels', \App\Http\Controllers\HotelController::class);

});


Route::get('tasks', [\App\Http\Controllers\TaskController::class, 'index']);
Route::post('tasks', [\App\Http\Controllers\TaskController::class, 'store']);
Route::get('tasks/{id}', [\App\Http\Controllers\TaskController::class, 'show']);
Route::put('tasks/{id}', [\App\Http\Controllers\TaskController::class, 'update']);
Route::delete('tasks/{id}', [\App\Http\Controllers\TaskController::class, 'destroy']);
Route::post('register', [\App\Http\Controllers\UserController::class, 'register']);
Route::apiResource('projects', \App\Http\Controllers\ProjectController::class);
Route::apiResource('products', \App\Http\Controllers\ProjectController::class);

