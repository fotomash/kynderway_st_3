<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Mobile\AuthController;
use App\Http\Controllers\Api\Mobile\UserController;
use App\Http\Controllers\Api\Mobile\HomeController;
use App\Http\Controllers\Api\Mobile\NannyController;
use App\Http\Controllers\Api\Mobile\BookingController;
use App\Http\Controllers\Api\Mobile\DeviceController;

Route::prefix('mobile/v1')
    ->middleware(['api', 'throttle:mobile-api'])
    ->group(function () {
        // Public
        Route::post('/login', [AuthController::class, 'login']);

        // Protected
        Route::middleware('auth:sanctum')->group(function () {
            Route::post('/logout', [AuthController::class, 'logout']);
            Route::get('/home', [HomeController::class, 'index']);
            Route::get('/nannies/nearby', [NannyController::class, 'nearby']);
            Route::get('/bookings/active', [BookingController::class, 'active']);
            Route::post('/device/register', [DeviceController::class, 'register']);
            Route::post('/device/unregister', [DeviceController::class, 'unregister']);

            Route::get('/user', [UserController::class, 'profile']);
            Route::put('/user', [UserController::class, 'update']);
            Route::post('/bookings', [BookingController::class, 'store']);
            Route::post('/bookings/{booking}/complete', [BookingController::class, 'complete']);
        });
    });
