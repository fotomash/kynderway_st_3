<?php

use Chatify\Http\Models\Message;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\JobPostController;
use App\Http\Controllers\JobOfferController;
use App\Http\Controllers\ProfilePostController;
use App\Http\Controllers\EmailsController;
use Illuminate\Http\Request;
use App\Models\User_Connections;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\MailingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/clear', function () {   //optimized
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    Artisan::call('route:cache');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    Artisan::call('view:cache');
    return '<h1>Cache cleared</h1>';
});


Route::get('/get-unseen-message-count', function (Request $request) {
    if ($request->ajax()) {
        $count = 0;
        $userId = $request->input('userId');
        $connectionId = $request->input('connectionId');
       
        if ($connectionId != '') {
            $count = Message::where([
                ['reference_id', '=', $connectionId],
                ['to_id', '=', $userId]
            ])->where('seen', 0)->count();
            return response()->json(['count' => $count]);
        }
    }
});

Route::get('/get-new-job-notification', [ClientController::class, 'getNewJobNotification'])->name('get.new.job.notification');
Route::get('/get-new-job-notification-provider', [ProviderController::class, 'getNewJobNotification'])->name('get.new.job.notification');

//Guest Routes
Route::get('/', [GuestController::class, 'index']);   //optimized
Route::get('/{id}/download-file', [GuestController::class, 'downloadFile']);
Route::get('/jobs/{slug}', [GuestController::class, 'getJob']);
//Route::get('/job/{category_slug}/{profile_slug}',  [GuestController::class, 'getJob']);
Route::get('/profile/{category_slug}/{profile_slug}', [GuestController::class, 'getProfile']);

Route::get('/search-jobs', [ProviderController::class, 'searchJobs']);
Route::get('/search-providers', [GuestController::class, 'searchProviders']);
Route::post('/search-providerbar', [GuestController::class, 'getSearchProviderbar']);
Route::post('/getjobtypes_guest/{id}', [GuestController::class, 'getAllJobtype']);
Route::get('/searchprovider_ajax', [GuestController::class, 'searchProviderByAjx']);
Route::post('/setjobpost-connnect', [GuestController::class, 'setJobConnection']);
Route::get('/searchjobs_ajax', [ProviderController::class, 'searchjobsbyajax']);
Route::post('/getjobtypes/{id}', [ProviderController::class, 'getAllJobtype']);
Route::post('provider/search-sidebar', [ProviderController::class, 'getSearchSidebar']);

//Temporary Routes
Route::get('/update-slugs-job-posts', [GuestController::class, 'updateJobPostSlugs']);
Route::get('/update-slugs-profile-posts', [GuestController::class, 'updateProfilePostSlugs']);
Route::get('/update-slugs-profile-categories', [GuestController::class, 'updateProfileCategoriesSlugs']);

// Client  Routes
Route::group([
    'prefix' => 'user/client',
    'middleware' => ['web', 'auth', 'is_client', 'verified', 'nocache']
], function () {
    Route::get('/', [ClientController::class, 'dashboard']);
    Route::get('/dashboard', [ClientController::class, 'dashboard']);
    Route::get('/manage-profile', [ClientController::class, 'manageProfile']);
    Route::get('/manage-account', [ClientController::class, 'manageAccount']);   //optimized
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
    Route::post('/soft_delete', [UserController::class, 'hardDelete']);   //optimized
    Route::post('/add_jobpost1', [ClientController::class, 'addjobpost1']);
    Route::post('/report-connection', [ReportController::class, 'create']);
  
    Route::post('/documents/request-access', [ClientController::class, 'requestAccess'])->name('documents.request-access');
    
});

// Provider Routes
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
    Route::get('/manage-account', [ProviderController::class, 'manageAccount']);   //optimized
    Route::get('/get-verified', [ProviderController::class, 'getVerified']);
    Route::post('/verified', [ProviderController::class, 'verified']);   //optimized
    // Route::get('/search-jobs', [ProviderController::class, 'searchJobs']);
    //Route::post('/search-sidebar', [ProviderController::class, 'getSearchSidebar']);
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
        Route::get('/', [ProviderController::class, 'serviceProfiles']);   //optimized
        Route::get('/nanny', [ProviderController::class, 'nanny']);
        Route::get('/maternity-nurse', [ProviderController::class, 'maternityNurse']);
        Route::post('/set-not-new', [ProviderController::class, 'setNotNew']);

//        Route::get('/carer', [ProviderController::class, 'carer']);
//        Route::get('/pet-carer', [ProviderController::class, 'petCarer']);
//        Route::get('/tutor', [ProviderController::class, 'tutor']);
        Route::get('/cleaner', [ProviderController::class, 'cleaner']);
        Route::get('/housekeeper', [ProviderController::class, 'housekeeper']);

        Route::post('/addallprofiles', [ProviderController::class, 'addProfiles']);
    });

    Route::post('/update_profile_picture', [ProviderController::class, 'update_profile_picture']);
    Route::post('/update_user_profile', [ProviderController::class, 'update_user_profile']);
    Route::post('/change_password', [ProviderController::class, 'change_password']);
    Route::post('/get_details_from_postal_code', [ProviderController::class, 'get_details_from_postal_code']);
    Route::post('/soft_delete', [UserController::class, 'hardDelete']);   //optimized
});

// Admin Routes
Route::group([
    'prefix' => 'admin',
    'middleware' => ['web', 'auth', 'is_admin', 'nocache']
], function () {
    Route::get('/', function () {   //optimized
        return redirect('/admin/users');
    });
    Route::get('/dashboard', [AdminController::class, 'dashboard']);   //optimized

    Route::get('/users', [AdminController::class, 'users']);   //optimized
    Route::get('/deleted-users', [AdminController::class, 'deletedUsers']);   //optimized
    Route::get('/delete-request', [AdminController::class, 'deleteRequest']);   //optimized
    Route::post('/add-notes', [AdminController::class, 'adminAddNotes']);   //optimized
    Route::post('/update-block-status', [AdminController::class, 'updateUserStatus']);   //optimized
    Route::post('/delete-user', [AdminController::class, 'softDeleteUser']);   //optimized
    Route::get('/assign-user/{id}', [AdminController::class, 'assignUser']);   //optimized

    Route::get('/messages', [AdminController::class, 'listMessages']);   //optimized
    Route::get('/messages-detail/{id}', [AdminController::class, 'showMessages']);   //optimized
    Route::get('/logout', [AdminController::class, 'logout']);   //optimized
    Route::get('/change-password', function () {   //optimized
        return view('admin.change-password');
    });
    Route::post('/change-password', [AdminController::class, 'changePassword']);   //optimized

    Route::get('/pre-checked-provider/pending', [AdminController::class, 'providerPendingRequest']);   //optimized
    Route::get('/assign-user-pending-verification/{id}', [AdminController::class, 'assignUserToVerificationRequest']);   //optimized
    Route::post('/add-verify-notes', [AdminController::class, 'adminAddVerifyNotes']);   //optimized
    Route::post('/update-verified-status', [AdminController::class, 'updateVerificationStatus']);   //optimized
    Route::get('/pre-checked-provider/history', [AdminController::class, 'showVerificationHistory']);   //optimized

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

    Route::get('/work-profiles', [ProfilePostController::class, 'index']);   //optimized
    Route::post('/update-profile-status', [ProfilePostController::class, 'updateProfileStatus']);   //optimized
    Route::post('/update-profile-select', [ProfilePostController::class, 'updateSelectStatus']);   //optimized
    Route::post('/admin-delete-profile', [ProfilePostController::class, 'deleteProfile']);   //optimized
    Route::get('/profile-post-show/{id}', [ProfilePostController::class, 'show']);   //optimized
    Route::get('/assign-user-profilepost/{id}', [ProfilePostController::class, 'assignUser']);   //optimized
    Route::post('/add-profile-notes', [ProfilePostController::class, 'adminAddProfileNotes']);   //optimized

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

//General Routes
Route::get('/user/check-new', function () {
    if (Auth::check()) {
        return response()->json(['is_new' => Auth::user()->is_new]);
    } else {
        return response()->json(['error' => 'Not authenticated']);
    }
});


Route::post('/user/exit-intro', function () {
    if (Auth::check()) {
        $user = Auth::user();
        $user->is_new = 0;
        $user->save();

        return response()->json(['success' => 'User updated']);
    } else {
        return response()->json(['error' => 'Not authenticated']);
    }
});

Route::get('/php-get', [GuestController::class, 'getPhpInfo']);   //optimized

Route::get('/mail/admin-delete-user-account', [EmailsController::class, 'adminAccountDelete']);   //optimized
Route::get('/mail/user-account-delete', [EmailsController::class, 'userAccountDelete']);   //optimized
Route::get('/mail/send-job-offers', [EmailsController::class, 'sendJobOffers']);

Route::post('/verify-otp', [UserController::class, 'verifyOTP'])   //optimized
        ->middleware('auth')
        ->name('verification.otp');

Route::post('/verify-resend-otp', [UserController::class, 'verifyResendOTP'])   //optimized
        ->middleware('auth')
        ->name('verification.resend.otp');

Route::get('/view-pdf', [GuestController::class, 'viewPDF']);
Route::get('/unsubscribe/{email}', [GuestController::class, 'unsubscribe']);



require __DIR__.'/auth.php';
