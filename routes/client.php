<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;

Route::group([
    'prefix' => 'user/client',
    'middleware' => ['web', 'auth', 'is_client', 'verified', 'nocache']
], function () {
    Route::get('/', [ClientController::class, 'dashboard']);
    Route::get('/dashboard', [ClientController::class, 'dashboard']);
    Route::get('/manage-profile', [ClientController::class, 'manageProfile']);
    Route::get('/manage-account', [ClientController::class, 'manageAccount']);
    Route::get('/post-vacancy', [ClientController::class, 'postVacancy']);
    Route::get('/post-vacancy/{id}', [ClientController::class, 'postVacancyEdit']);
    Route::get('/post-vacancy-model/{id}', [ClientController::class, 'postVacancyEditModel']);
    Route::post('/post-vacancy/{id}', [ClientController::class, 'savePostVacancyEdit']);

    Route::post('/dashboard-loadmore', [ClientController::class, 'getDashboarLoadMore']);
    Route::post('/cancel-connection', [ClientController::class, 'deleteConnection']);
    Route::post('/approve-connection', [ClientController::class, 'approveConnection']);
    Route::post('/view-userdetails', [ClientController::class, 'getUserDetails']);
    Route::post('/pause-job', [ClientController::class, 'stopJob']);
    Route::post('/delete-job', [ClientController::class, 'jobSoftDelete']);
    Route::post('/view-job', [ClientController::class, 'viewFullJob']);
    Route::post('/update-job-note', [ClientController::class, 'updateJobNote']);
    Route::post('/update-application-job-note', [ClientController::class, 'updateApplicationJobNote']);

    Route::post('/getjobtypes/{id}', [ClientController::class, 'getAllJobtype']);
    Route::post('/getall_loader/{id}', [ClientController::class, 'getAllLoaders']);
    Route::post('/postnew_vacancy', [ClientController::class, 'addjobpost']);
    Route::get('/logout', [ClientController::class, 'logout']);

    Route::post('/update_profile_picture', [ClientController::class, 'update_profile_picture']);
    Route::post('/update_user_profile', [ClientController::class, 'update_user_profile']);
    Route::post('/change_password', [ClientController::class, 'change_password']);
    Route::post('/get_details_from_postal_code', [ClientController::class, 'get_details_from_postal_code']);
    Route::post('/soft_delete', [UserController::class, 'hardDelete']);
    Route::post('/add_jobpost1', [ClientController::class, 'addjobpost1']);
    Route::post('/report-connection', [ReportController::class, 'create']);

    Route::post('/documents/request-access', [ClientController::class, 'requestAccess'])->name('documents.request-access');
});
