<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;

Route::group([
    'prefix' => 'provider',
    'middleware' => ['web', 'auth', 'is_provider', 'verified', 'nocache']
], function () {
    Route::get('/', [ProviderController::class, 'dashboard']);
    Route::get('/dashboard', [ProviderController::class, 'dashboard']);
    Route::get('/manage-profile', [ProviderController::class, 'manageProfile']);
    Route::get('/manage-documents', [ProviderController::class, 'manageDocuments']);
    Route::post('/add-document', [ProviderController::class, 'addDocument']);
    Route::delete('/{id}/delete-document', [ProviderController::class, 'deleteDocument']);
    Route::post('/give-access', [ProviderController::class, 'giveAccess']);
    Route::get('/video-intro', [ProviderController::class, 'videoIntro']);
    Route::get('/manage-account', [ProviderController::class, 'manageAccount']);
    Route::get('/get-verified', [ProviderController::class, 'getVerified']);
    Route::post('/verified', [ProviderController::class, 'verified']);
    Route::post('/setprovider-connnect', [ProviderController::class, 'set_provider_connection']);

    Route::post('/viewjobdetails', [ProviderController::class, 'getjobdetails']);
    Route::post('/cancelconnection', [ProviderController::class, 'deleteconnection']);
    Route::post('/approve-connection', [ProviderController::class, 'approveConnection']);
    Route::post('/report-connection', [ReportController::class, 'create']);

    Route::get('/searchjobs_ajax', [ProviderController::class, 'searchjobsbyajax']);
    Route::post('/getjobtypes/{id}', [ProviderController::class, 'getAllJobtype']);
    Route::get('/logout', [ProviderController::class, 'logout']);
    Route::post('/add-getverified', [ProviderController::class, 'addGetVerified']);
    Route::post('/add-videointro', [ProviderController::class, 'addvideointro']);
    Route::post('/deletelanguage', [ProviderController::class, 'deleteOtherLanguage']);
    Route::delete('/{id}/delete-profile', [ProviderController::class, 'deleteProfile']);
    Route::post('/documents/respond-to-request/{id}', [ProviderController::class, 'respondToRequest'])->name('documents.respond-access');
    Route::post('/documents/grant-access', [ProviderController::class, 'grantAccess'])->name('documents.grant-access');
    Route::post('/documents/block-access', [ProviderController::class, 'blockAccess'])->name('documents.block-access');
    Route::group([
        'prefix' => 'service-profiles'
    ], function () {
        Route::get('/', [ProviderController::class, 'serviceProfiles']);
        Route::get('/nanny', [ProviderController::class, 'nanny']);
        Route::get('/maternity-nurse', [ProviderController::class, 'maternityNurse']);
        Route::post('/set-not-new', [ProviderController::class, 'setNotNew']);
        Route::get('/cleaner', [ProviderController::class, 'cleaner']);
        Route::get('/housekeeper', [ProviderController::class, 'housekeeper']);
        Route::post('/addallprofiles', [ProviderController::class, 'addProfiles']);
    });

    Route::post('/update_profile_picture', [ProviderController::class, 'update_profile_picture']);
    Route::post('/update_user_profile', [ProviderController::class, 'update_user_profile']);
    Route::post('/change_password', [ProviderController::class, 'change_password']);
    Route::post('/get_details_from_postal_code', [ProviderController::class, 'get_details_from_postal_code']);
    Route::post('/soft_delete', [UserController::class, 'hardDelete']);
});
