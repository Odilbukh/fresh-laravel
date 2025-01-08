<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('auth', [AuthController::class, 'auth']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::apiResource('bookings', BookingController::class);
    Route::apiResource('rooms', RoomController::class);
    Route::apiResource('services', \App\Http\Controllers\ServiceController::class);
    Route::apiResource('invoices', \App\Http\Controllers\InvoiceController::class);
    Route::apiResource('notifications', \App\Http\Controllers\NotificationController::class);
    Route::middleware('isAdmin')->group(function () {
//        Route::apiResource('rooms', RoomController::class);
        Route::apiResource('roles', \App\Http\Controllers\RoleController::class);
        Route::get('users', [\App\Http\Controllers\UserController::class, 'index']);
        Route::post('users', [\App\Http\Controllers\UserController::class, 'store']);
        Route::get('users/{id}', [\App\Http\Controllers\UserController::class, 'show']);
        Route::put('users/{id}', [\App\Http\Controllers\UserController::class, 'update']);
        Route::delete('users/{id}', [\App\Http\Controllers\UserController::class, 'destroy']);

    });
    Route::apiResource('hotels', \App\Http\Controllers\HotelController::class);
});
//Route::post('bookings', [\App\Http\Controllers\BookingController::class, 'store']);
Route::get('tasks', [\App\Http\Controllers\TaskController::class, 'index']);
Route::post('tasks', [\App\Http\Controllers\TaskController::class, 'store']);
Route::get('tasks/{id}', [\App\Http\Controllers\TaskController::class, 'show']);
Route::put('tasks/{id}', [\App\Http\Controllers\TaskController::class, 'update']);
Route::delete('tasks/{id}', [\App\Http\Controllers\TaskController::class, 'destroy']);
Route::post('register', [\App\Http\Controllers\UserController::class, 'register']);
Route::apiResource('projects', \App\Http\Controllers\ProjectController::class);
Route::apiResource('products', \App\Http\Controllers\ProductController::class);

