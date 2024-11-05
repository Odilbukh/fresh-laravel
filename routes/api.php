<?php

use Illuminate\Support\Facades\Route;

Route::get('users', [\App\Http\Controllers\UserController::class, 'index']);
Route::post('users', [\App\Http\Controllers\UserController::class, 'store']);
Route::get('users/{id}', [\App\Http\Controllers\UserController::class, 'show']);
Route::put('users/{id}', [\App\Http\Controllers\UserController::class, 'update']);
Route::delete('users/{id}', [\App\Http\Controllers\UserController::class, 'destroy']);

Route::get('tasks', [\App\Http\Controllers\TaskController::class, 'index']);
Route::post('tasks', [\App\Http\Controllers\TaskController::class, 'store']);
Route::get('tasks/{id}', [\App\Http\Controllers\TaskController::class, 'show']);
Route::put('tasks/{id}', [\App\Http\Controllers\TaskController::class, 'update']);
Route::delete('tasks/{id}', [\App\Http\Controllers\TaskController::class, 'destroy']);

Route::apiResource('projects', \App\Http\Controllers\ProjectController::class);
Route::resource('roles', \App\Http\Controllers\RoleController::class);
