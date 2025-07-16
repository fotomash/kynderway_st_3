<?php

use App\Http\Controllers\MetricsController;
use App\Http\Controllers\HealthController;
use Illuminate\Support\Facades\Route;

Route::get('/metrics', MetricsController::class);
Route::get('/health', HealthController::class);
