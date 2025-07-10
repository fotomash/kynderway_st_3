<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\JobPostController;
use App\Http\Controllers\ProfilePostController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\JobOfferController;
use App\Http\Controllers\MailingController;

Route::group([
    'prefix' => 'admin',
    'middleware' => ['web', 'auth', 'is_admin', 'nocache']
], function () {
    Route::get('/', function () {
        return redirect('/admin/users');
    });
    Route::get('/dashboard', [AdminController::class, 'dashboard']);

    Route::get('/users', [AdminController::class, 'users']);
    Route::get('/deleted-users', [AdminController::class, 'deletedUsers']);
    Route::get('/delete-request', [AdminController::class, 'deleteRequest']);
    Route::post('/add-notes', [AdminController::class, 'adminAddNotes']);
    Route::post('/update-block-status', [AdminController::class, 'updateUserStatus']);
    Route::post('/delete-user', [AdminController::class, 'softDeleteUser']);
    Route::get('/assign-user/{id}', [AdminController::class, 'assignUser']);

    Route::get('/messages', [AdminController::class, 'listMessages']);
    Route::get('/messages-detail/{id}', [AdminController::class, 'showMessages']);
    Route::get('/logout', [AdminController::class, 'logout']);
    Route::get('/change-password', function () {
        return view('admin.change-password');
    });
    Route::post('/change-password', [AdminController::class, 'changePassword']);

    Route::get('/pre-checked-provider/pending', [AdminController::class, 'providerPendingRequest']);
    Route::get('/assign-user-pending-verification/{id}', [AdminController::class, 'assignUserToVerificationRequest']);
    Route::post('/add-verify-notes', [AdminController::class, 'adminAddVerifyNotes']);
    Route::post('/update-verified-status', [AdminController::class, 'updateVerificationStatus']);
    Route::get('/pre-checked-provider/history', [AdminController::class, 'showVerificationHistory']);

    Route::get('/job-post', [JobPostController::class, 'index']);
    Route::post('/update-job-status', [JobPostController::class, 'updateJobStatus']);
    Route::post('/update-job-select', [JobPostController::class, 'updateJobSelect']);
    Route::post('/admin-delete-job', [JobPostController::class, 'deleteJob']);
    Route::post('/admin-delete-job-offer', [JobPostController::class, 'deleteJobOffer']);
    Route::get('/deleted-jobs', [JobPostController::class, 'deletedJobs']);
    Route::get('/job-post-show/{id}/{type}', [JobPostController::class, 'show']);
    Route::get('/assign-user-jobpost/{id}', [JobPostController::class, 'assignUser']);
    Route::post('/add-job-notes', [JobPostController::class, 'adminAddJobNotes']);
    Route::post('/send-mails', [JobPostController::class, 'sendNewsletter']);
    Route::get('/preview-mail', [JobPostController::class, 'previewNewsletter']);

    Route::get('/work-profiles', [ProfilePostController::class, 'index']);
    Route::post('/update-profile-status', [ProfilePostController::class, 'updateProfileStatus']);
    Route::post('/update-profile-select', [ProfilePostController::class, 'updateSelectStatus']);
    Route::post('/admin-delete-profile', [ProfilePostController::class, 'deleteProfile']);
    Route::get('/profile-post-show/{id}', [ProfilePostController::class, 'show']);
    Route::get('/assign-user-profilepost/{id}', [ProfilePostController::class, 'assignUser']);
    Route::post('/add-profile-notes', [ProfilePostController::class, 'adminAddProfileNotes']);

    Route::get('/reports/{type}/{status}', [ReportController::class, 'index']);
    Route::get('/report-show/{id}', [JobPostController::class, 'showReport']);
    Route::get('/assign-user-report/{id}', [ReportController::class, 'assignUserToReport']);
    Route::get('/report-user-reason-show/{id}', [ReportController::class, 'showReportedUsers']);
    Route::post('/add-report-notes', [ReportController::class, 'adminAddReportNotes']);
    Route::get('/user-report-list/{id}', [ReportController::class, 'userReportList']);

    Route::get('/job-offer', [JobOfferController::class, 'offer']);
    Route::get('/add-to-job-offers/{id}', [JobOfferController::class, 'add']);
    Route::post('send-job-offers', [JobOfferController::class, 'sendJobOffers']);
    Route::get('/mailing', [MailingController::class, 'index']);
});
