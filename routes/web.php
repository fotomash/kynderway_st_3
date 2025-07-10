<?php

use Chatify\Http\Models\Message;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

use App\Http\Controllers\UserController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\EmailsController;
use Illuminate\Http\Request;
use App\Models\User_Connections;
use Illuminate\Support\Facades\Auth;

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
