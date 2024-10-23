<?php

use Illuminate\Support\Facades\Route;

Route::get('hello', function () {
    return response()->json('Hello World');
});

Route::get('users', [\App\Http\Controllers\UserController::class, 'index']);
Route::post('users', [\App\Http\Controllers\UserController::class, 'store']);
Route::get('users/{id}', [\App\Http\Controllers\UserController::class, 'show']);
Route::put('users/{id}', [\App\Http\Controllers\UserController::class, 'update']);
Route::delete('users/{id}', [\App\Http\Controllers\UserController::class, 'destroy']);
