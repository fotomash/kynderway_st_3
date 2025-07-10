<?php

namespace App\Http\Controllers;

use App\Events\AccountActivate;
use App\Events\AccountSuspend;
use App\Events\UserAccountDeleteEvent;
use App\Events\UserDeleteEmailAdminEvent;
use App\Events\UserVerificationApproved;
use App\Events\UserVerificationRejected;
use App\Http\Requests\ChangePasswordRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Services\AdminService;
use App\Services\MessageService;
use App\Services\GetVerifiedService;
use App\Services\JobPostService;
use App\Services\UserConnectionService;
use App\Services\UserService;
use App\Services\ProfilePostService;
use App\Services\LanguageUserService;
use App\Services\VideoService;

class AdminController extends Controller
{
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
        AdminService $adminService,
        MessageService $messageService,
        GetVerifiedService $getVerifiedService,
        UserService $userService,
        UserConnectionService $userConnectionService,
        JobPostService $jobPostService,
        ProfilePostService $profilePostService,
        LanguageUserService $languageUserService,
        VideoService $videoService
    ) {
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

    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function users()
    {
        $users = $this->adminService->getUsers();
        return view('admin.users', compact('users'));
    }

    public function deleteRequest()
    {
        $users = $this->adminService->deleteRequestUsers();
        return view('admin.users-request', compact('users'));
    }

    public function deletedUsers()
    {
        $users = $this->adminService->deletedUsers();
        return view('admin.deleted-users', compact('users'));
    }

    public function showVerificationHistory()
    {
        $verificationHistory = $this->adminService->getVerificationHistory();

        // Filter out requests where the user is null
        $verificationHistory = $verificationHistory->filter(function ($request) {
            return $request->user !== null;
        })->values(); // Reset the keys

        return view('admin.verification-history', ['pendingRequests' => $verificationHistory]);
    }

    public function providerPendingRequest()
    {
        $pendingRequests = $this->adminService->getPendingProvidersRequests();
        return view('admin.pending-request', compact('pendingRequests'));
    }

    public function updateVerificationStatus(Request $request)
    {
        $verifiedId = $request->verifiedId;
        $setStatus = $request->setStatus;
        $comment = $request->comment;

        if ($verifiedId != '' && $setStatus != '') {
            $update_verified_data = $this->getVerifiedService->get($verifiedId);
            $user_id = $update_verified_data->provider_id;
            $user = $this->userService->getUser($user_id);

            //Send email if rejected or approved.
            if ($setStatus == 1) {
                event(new UserVerificationApproved($user));
            } else {
                event(new UserVerificationRejected($user));
            }
            //Delete images from storage and database.
            if ($update_verified_data->identification_doc != null) {
                unlink(storage_path('app/public/'.$update_verified_data->identification_doc));
            }

            if ($update_verified_data->reference_doc != null) {
                unlink(storage_path('app/public/'.$update_verified_data->reference_doc));
            }

            $this->getVerifiedService->updateDataOnVerificationSuccess($verifiedId, $setStatus, $comment);

            // return Response::json(['success' => '1', 'message'=>'Verification Status Changed Successfully']);
            return back()->with('alert-success', 'Verification status changed successfully');
        }
    }

    public function adminAddNotes(Request $request)
    {
        $userId = $request->userId;
        $notes = $request->comment;
        if ($userId != '') {
            $this->adminService->updateUserNotes($userId, $notes);
            return back()->with('alert-success', 'Notes added successfully');
        }
    }

    public function adminAddVerifyNotes(Request $request)
    {
        $verifyId = $request->verifyId;
        $notes = $request->commentvalue;
        if ($verifyId != '') {
            $this->adminService->updateGetVerifiedNotes($verifyId, $notes);
            return back()->with('alert-success', 'Notes added successfully');
        }
    }

    public function assignUser($mainUserId)
    {
        $adminId = Auth::user()->id;
        if ($mainUserId != '') {
            $mainUser = $this->adminService->getUser($mainUserId);
            if ($mainUser === null) {
                return back()->with('alert-warning', 'Invalid user');
            }
            if ($mainUser->assign_user_id !== null) {
                return back()->with('alert-warning', 'User already assign');
            }

            $this->adminService->assignAdminToUser($mainUserId, $adminId);
            return back()->with('alert-success', 'Assigned successfully');
        }
    }

    public function assignUserToVerificationRequest($verifyId)
    {
        $adminId = Auth::user()->id;
        if ($verifyId != '') {
            $verified_data = $this->getVerifiedService->get($verifyId);
            if ($verified_data === null) {
                return back()->with('alert-warning', 'Invalid provider verification request');
            }
            if ($verified_data->assigned_user_id !== null) {
                return back()->with('alert-warning', 'Provider verification request already assign');
            }

            $this->getVerifiedService->assignAdmin($verifyId, $adminId);
            return back()->with('alert-success', 'Assigned successfully');
        }
    }

    public function updateUserStatus(Request $request)
    {
        $userId = $request->statusUserId;
        $setStatus = $request->setStatus;

        if ($userId != '' && $setStatus != '') {
            $this->userService->updateBlockStatus($userId, $setStatus);

            //Send mail to user when account status changed to suspend(1)
            $userDetails = $this->userService->getUser($userId);
            if ($setStatus == 1) {
                event(new AccountSuspend($userDetails));
            } else {
                event(new AccountActivate($userDetails));
            }

            $statusMessage = $setStatus == 1 ? 'suspended' : 'activated';
            return back()->with('alert-success', 'User account ' . $statusMessage . ' successfully');
        }
    }

    public function softDeleteUser(Request $request)
    {
        $id = $request->deleteUserId;
        $type = $request->deleteType;

        if ($id != '') {
            $user = $this->userService->getUser($id);
            if ($user) {
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

                if ($type == 'Soft') {
                    $this->userService->softDelete($user->id, Auth::user()->id);
                } else {
                    $this->userService->hardDelete($user->id);
                }

                event(new UserAccountDeleteEvent($user, $type));
                event(new UserDeleteEmailAdminEvent($user));
                return back()->with('alert-success', 'User account deleted successfully');
            }
        }
    }

    public function listMessages(Request $request)
    {
        $messageLists = $this->messageService->getMessageList();
        return view('admin.message-list', compact('messageLists'));
    }

    public function showMessages($messageid)
    {
        if ($messageid != '') {
            $messageDetails = $this->messageService->getMessages($messageid);

            $getJobDetail = $this->messageService->getJobDetails($messageid);

            $data['jobtitle'] = $getJobDetail['connection']['job']['jobtitle']??'';

            //Get provider type and name
            // $data[$getJobDetail['connection']['job_provider']['id']]['providername'] = $getJobDetail['connection']['job_provider']['name'].' '.$getJobDetail['connection']['job_provider']['last_name'];
            if (!isset($getJobDetail['connection']['job_provider']['id'])) {
                return back()->with('alert-danger', 'Job provider was not found');
            }
            $data[$getJobDetail['connection']['job_provider']['id']]['providername'] = isset($getJobDetail['connection']['job_provider']['name']) ? $getJobDetail['connection']['job_provider']['name'] : '';
            $data[$getJobDetail['connection']['job_provider']['id']]['settype'] = $getJobDetail['connection']['job_provider']['type']??'';

            //Get job poster type and name
            // $data[$getJobDetail['connection']['job_poster']['id']]['postername'] = $getJobDetail['connection']['job_poster']['name'].' '.$getJobDetail['connection']['job_poster']['last_name'];
            $data[$getJobDetail['connection']['job_poster']['id']]['postername'] = $getJobDetail['connection']['job_poster']['name']??'';
            $data[$getJobDetail['connection']['job_poster']['id']]['settype'] = $getJobDetail['connection']['job_poster']['type']??'';

            return view('admin.message-detail', compact('messageDetails', 'data'));
        }
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $data = $request->validated();
        $user = $this->userService->getUser(auth()->user()->id);

        if (!Hash::check($data['old_password'], $user->password)) {
            return back()->with('alert-warning', 'Invalid current password');
        } else {
            $this->userService->updateUserPassword(auth()->user()->id, $request->new_password);
            return back()->with('alert-success', 'Password changed successfully!');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
