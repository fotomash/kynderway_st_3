<?php

use App\Http\Controllers\Api\V1\JobController;
use App\Http\Controllers\Api\V1\ProfileController;
use App\Http\Controllers\Api\MapsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v1')->group(function () {
    Route::apiResource('jobs', JobController::class)->only(['index', 'show']);
    Route::apiResource('profiles', ProfileController::class)->only(['index', 'show']);
    Route::get('profiles/nearby', [ProfileController::class, 'nearby']);
});

Route::post('maps/geocode', [MapsController::class, 'geocode']);
