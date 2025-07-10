<?php

namespace App\Http\Controllers;

use App\Events\UserAccountDeleteEvent;
use App\Events\UserDeleteEmailAdminEvent;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Providers\RouteServiceProvider;
use App\Models\countries;
use App\Models\Document;
use App\Services\AdminService;
use App\Services\MessageService;
use App\Services\GetVerifiedService;
use App\Services\JobPostService;
use App\Services\UserConnectionService;
use App\Services\UserService;
use App\Services\ProfilePostService;
use App\Services\LanguageUserService;
use App\Services\VideoService;

use Carbon\Carbon;

use Session;
use Response;

class UserController extends Controller
{
    protected $basic_detail;

    private $adminService;
    private $messageService;
    private $getVerifiedService;
    private $userService;
    private $userConnectionService;
    private $jobPostService;
    private $profilePostService;
    private $languageUserService;
    private $videoService;


    public function __construct(
        UserService $userService,
        AdminService $adminService,
        MessageService $messageService,
        GetVerifiedService $getVerifiedService,
        UserConnectionService $userConnectionService,
        JobPostService $jobPostService,
        ProfilePostService $profilePostService,
        LanguageUserService $languageUserService,
        VideoService $videoService
    ) {
        $this->basic_detail['countries'] = countries::all();
        $this->adminService = $adminService;
        $this->messageService = $messageService;
        $this->getVerifiedService = $getVerifiedService;
        $this->userService = $userService;
        $this->userConnectionService = $userConnectionService;
        $this->jobPostService = $jobPostService;
        $this->profilePostService = $profilePostService;
        $this->languageUserService = $languageUserService;
        $this->videoService = $videoService;
    }

    // public function dashboard() {
    //     return view('user.client.dashboard');
    // }

    // public function manageProfile() {
    //     $this->basic_detail['profile_picture'] = Storage::url(Auth::user()->profile_picture);
    //     return view('user.client.manage-profile', $this->basic_detail);
    // }

    // public function postVacancy() {
    //     return view('user.client.post-vacancy');
    // }

    // public function manageAccount() {
    //     return view('user.client.manage-account');
    // }

    // public function update_user_profile(Request $request) {
    //     $request->validate([
    //         'name' => 'required',
    //         'last_name' => 'required',
    //         'phone_code' => 'required',
    //         'phone' => 'required',
    //         'country' => 'required',
    //         'city' => 'required',
    //         'landmark' => 'required',
    //     ]);
    //     $data = $request->All();

    //     $name = (isset($data['name'])) ? $data['name'] : '';
    //     $last_name = (isset($data['last_name'])) ? $data['last_name'] : '';
    //     $phone_code = (isset($data['phone_code'])) ? $data['phone_code'] : '';
    //     $phone = (isset($data['phone'])) ? $data['phone'] : '';
    //     $secondary_notifications = (isset($data['secondary_notifications'])) ? 1 : 0;
    //     $country = (isset($data['country'])) ? $data['country'] : '';
    //     $city = (isset($data['city'])) ? $data['city'] : '';
    //     $postal_code = (isset($data['postal_code'])) ? $data['postal_code'] : '';
    //     $landmark = (isset($data['landmark'])) ? $data['landmark'] : '';
    //     $address = (isset($data['address'])) ? $data['address'] : '';

    //     User::where('id', Auth::user()->id)->update([
    //         'name' => $name,
    //         'last_name' => $last_name,
    //         'phone_code' => $phone_code,
    //         'phone' => $phone,
    //         'secondary_notifications' => $secondary_notifications,
    //         'country' => $country,
    //         'city' => $city,
    //         'postal_code' => $postal_code,
    //         'landmark' => $landmark,
    //         'address' => $address,
    //     ]);
    //     return back()->with('success', 'Profile has been saved.');
    // }

    // public function change_password(Request $request) {
    //     $request->validate([
    //         'old_password' => 'required',
    //         'new_password' => 'required',
    //         'confirm_password' => 'required',
    //     ]);
    //     $data = $request->All();

    //     if (Hash::check($data['old_password'], Auth::user()->password)) {
    //         if ($data['confirm_password'] == $data['new_password']) {
    //             User::where('id', Auth::user()->id)->update(['password' => Hash::make($data['new_password'])]);
    //             return back()->with('success', 'Password has been updated.');
    //         }
    //     }
    //     return back()->with('warning', 'something went wrong.');
    // }

    // public function update_profile_picture(Request $request) {
    //     $request->validate([
    //         'profile_picture' => 'mimes:jpeg,jpg,png,gif,svg|required' //|max:10000 = max 10000kb
    //     ]);
    //     $data = $request->All();

    //     $path = $request->file('profile_picture')->store('profile_picture', 'public');
    //     User::where('id', Auth::user()->id)->update(['profile_picture' => $path]);
    //     return back()->with('success', 'Picture has been uploaded.');
    // }

    // public function get_details_from_postal_code(Request $request) {
    //     $data = $request->All();
    //     $success = 0;
    //     $response_data = array();
    //     $response_data = get_details_from_postal_code($data['postal_code']);
    //     if (count($response_data) > 0) {
    //         $countries = countries::where('name', $response_data['country'])->first();
    //         $response_data['phone_code'] = $countries->phone_code;
    //         $success = 1;
    //     }

    //     return response()->json([
    //                 'success' => $success,
    //                 'response_data' => $response_data
    //     ]);
    // }

    public function hardDelete()
    {
        if (Auth::check()) {
            $user = Auth::user();
            $deleteFlag = 1;
            if ($user->type == 'service_seeker') {
                foreach ($user->jobPosts as $job) {
                    if ($job->activeReports != null && $job->activeReports->count()) {
                        $deleteFlag = 0;
                        break;
                    }
                }
            }
            if ($user->type == 'service_provider') {
                foreach ($user->profileposts as $profile) {
                    if ($profile->activeReports != null && $profile->activeReports->count()) {
                        $deleteFlag = 0;
                        break;
                    }
                }
            }
            if ($deleteFlag) {
                $this->adminService->deleteStorageImages($user);
                $this->messageService->deleteFromTo($user);
                if ($user->type == 'service_seeker') {
                    $this->userConnectionService->deleteJobUserId($user);
                    $this->jobPostService->deleteReportsAndReportsUser($user);
                } else {
                    $this->userConnectionService->deleteProviderId($user);
                    $this->languageUserService->delete($user);
                    $this->videoService->delete($user);
                    $this->getVerifiedService->delete($user);
                    $this->profilePostService->delete($user);
                }

                event(new UserAccountDeleteEvent($user, 'Hard'));
                event(new UserDeleteEmailAdminEvent($user));

                $this->userService->hardDelete($user->id);
                Auth::logout();

                Session::flash('success', 'Account deleted successfully!');
                return Response::json(['success' => '1']);
            } else {
                $this->userService->updateDeleteRequest($user->id);

                // Session::flash('warning', 'You have been reported by other Users. Admin is reviewing your pending reports and will contact you soon.!');
                return Response::json(['success' => '2']);
            }
        } else {
            Session::flash('warning', 'Could not delete your account please try again after sometime.');
            return Response::json(['success' => '2']);
        }
    }

    public function verifyOTP(Request $request)
    {
        $user = Auth::user();
        if (!$request['otp'] || $request['otp'] != $user->otp) {
            return back()->with('alert-danger', 'Invalid OTP provided. Please try after with valid OTP.');
        }
        $date = Carbon::parse($user->otp_send_at);
        $now = Carbon::now();

        $diff = $date->diffInMinutes($now);
        if ($diff > 60) {
            return back()->with('alert-danger', 'This OTP is expired. Please using resend OTP.');
        }
        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
            $user->otp = null;
            $user->otp_send_at = null;
            $user->save();
        }

        $user_type = $user->type;
        $client_type = $user->client_type;
        $redirection_url = RouteServiceProvider::INDIVIDUAL_MANAGE_PROFILE;

        if ($user_type == "service_provider") {
            $redirection_url = RouteServiceProvider::PROVIDER_MANAGE_PROFILE;
        } else {
            if ($client_type == "Private") {
                $redirection_url = RouteServiceProvider::INDIVIDUAL_MANAGE_PROFILE;
            } else {
                $redirection_url = RouteServiceProvider::BUSINESS_MANAGE_PROFILE;
            }
        }
        return redirect($redirection_url.'?verified=1');
    }

    public function verifyResendOTP(Request $request)
    {
        $user = Auth::user();
        $this->userService->updateOTPDetails($user);
        $user = $this->userService->getUser($user->id);

        if ($user->sendEmailVerificationNotification(true)) {
            return back()->with('alert-success', 'OTP email sent successfully.');
        } else {
            return back()->with('alert-danger', 'Could not sent OTP email. Please try after some time.');
        }
    }
}
