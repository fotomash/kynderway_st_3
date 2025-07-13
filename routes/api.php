<?php

use App\Http\Controllers\Api\V1\JobController;
use App\Http\Controllers\Api\V1\ProfileController;
use App\Http\Controllers\Api\MapsController;
use App\Http\Controllers\Api\VacationCareController;
use App\Http\Controllers\Api\V1\PaymentController;
use App\Http\Controllers\KYCController;
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

Route::prefix('v1')
    ->middleware(['api', 'throttle:60,1'])
    ->as('v1.')
    ->group(function () {
        Route::apiResource('jobs', JobController::class)->only(['index', 'show']);
        Route::apiResource('profiles', ProfileController::class)->only(['index', 'show']);
        Route::get('profiles/nearby', [ProfileController::class, 'nearby']);
        Route::post('maps/geocode', [MapsController::class, 'geocode']);
        Route::post('vacation-care/search', [VacationCareController::class, 'searchVacationNannies']);

        Route::prefix('kyc')->middleware('auth:sanctum')->group(function () {
            Route::post('verify-document', [KYCController::class, 'verifyDocument']);
            Route::post('background-check', [KYCController::class, 'initiateBackgroundCheck']);
        });

Route::middleware('jwt.auth')->post('unlock-nanny/{id}', [\App\Http\Controllers\Api\BrowseController::class, 'unlockNanny']);
    });

Route::prefix('v1')->middleware(['auth:sanctum'])->group(function () {
    Route::post('payments/create-intent', [PaymentController::class, 'createIntent']);
    Route::post('payments/confirm', [PaymentController::class, 'confirm']);
    Route::post('payments/refund', [PaymentController::class, 'refund']);

    Route::post('providers/onboard', [PayoutController::class, 'startOnboarding']);
    Route::get('providers/onboard/callback', [PayoutController::class, 'onboardingCallback']);
    Route::post('providers/payout', [PayoutController::class, 'requestPayout']);
});

Route::post('stripe/webhook', StripeWebhookController::class);

Route::prefix('v2')
    ->middleware(['api', 'throttle:100,1'])
    ->as('v2.')
    ->group(function () {
        // Duplicate v1 endpoints for now; replace with v2 implementations as needed
        Route::apiResource('jobs', JobController::class)->only(['index', 'show']);
        Route::apiResource('profiles', ProfileController::class)->only(['index', 'show']);
        Route::get('profiles/nearby', [ProfileController::class, 'nearby']);
        Route::post('maps/geocode', [MapsController::class, 'geocode']);
        Route::post('vacation-care/search', [VacationCareController::class, 'searchVacationNannies']);

        Route::prefix('kyc')->middleware('auth:sanctum')->group(function () {
            Route::post('verify-document', [KYCController::class, 'verifyDocument']);
            Route::post('background-check', [KYCController::class, 'initiateBackgroundCheck']);
        });

        Route::middleware('jwt.auth')->post('unlock-nanny/{id}', [\App\Http\Controllers\Api\BrowseController::class, 'unlockNanny']);
    });
