<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Services\ProfilePostService;

use Response;

class ProfilePostController extends Controller
{
    private $profilePostService;

    public function __construct(ProfilePostService $profilePostService)
    {
        $this->profilePostService = $profilePostService;
    }

    public function index()
    {
        $profilePostLists = $this->profilePostService->getAllProfile();
        return view('admin.profile-list', compact('profilePostLists'));
    }

    public function assignUser($profilePostId)
    {
        $adminId = Auth::user()->id;

        if ($profilePostId != '') {
            $profile_exist_result = $this->profilePostService->profileExists($profilePostId);
            if (!$profile_exist_result) {
                return back()->with('alert-danger', 'Profile does not exist');
            }

            $profile_assigned_result = $this->profilePostService->profileAssigned($profilePostId);
            if (!$profile_assigned_result) {
                return back()->with('alert-warning', 'Profile already assigned');
            }

            $this->profilePostService->assignAdmin($profilePostId, $adminId);
            return back()->with('alert-success', 'Assigned successfully');
        }
        return back()->with('alert-danger', 'Something went wrong, assigning admin');
    }

    public function show($profileId)
    {
        if ($profileId != '') {
            $data = $this->profilePostService->getProfile($profileId);
            $profilePost = $data[0];
            $allJobTypes = $data[1];
            $allWorkWith = $data[2];

            $returnHTML = view('admin.profile-detail', compact('profilePost', 'allJobTypes', 'allWorkWith'))->render();
            return Response::json(['html' => $returnHTML]);
        }

        return Response::json(['html' => 'Something went wrong']);
    }

    public function adminAddProfileNotes(Request $request)
    {
        $profileId = $request->profileId;
        $notes = $request->comment;

        if ($profileId != '') {
            $this->profilePostService->updateNotes($profileId, $notes);
            return back()->with('alert-success', 'Notes added successfully');
        }
        return back()->with('alert-danger', 'Something went wrong, admin profile notes');
    }

    public function updateProfileStatus(Request $request)
    {
        $profileId = $request->statusProfileId;
        $setStatus = $request->setStatus;
        $reportCheck = isset($request->reportCheck) ? $request->reportCheck : 0;
        $suspendedBy = ($setStatus) ? '' : 'Admin';

        if ($profileId != '' && $setStatus != '') {
            $this->profilePostService->suspendActivateProfile($profileId, $setStatus, $suspendedBy, $reportCheck);
            $statusMessage = $setStatus == 1 ? 'Activated' : 'Suspended';
            return back()->with('alert-success', 'Profile ' . $statusMessage . ' successfully');
        }
        return back()->with('alert-danger', 'Something went wrong, update profile status');
    }

    public function updateSelectStatus(Request $request)
    {
        $profileId = $request->profileId;
        $select = $request->select;

        if ($profileId != '' && $select != '') {
            if ($select) {
                $countSelectedProfiles = $this->profilePostService->countSelectedProfiles($profileId);
                if ($countSelectedProfiles >= 5) {
                    return back()->with('alert-danger', 'Max 5 profiles per category limit reached');
                }
            }

            $this->profilePostService->updateSelectProfile($profileId, $select);

            $statusMessage = $select == 1 ? 'Selected' : 'Deselected';
            return back()->with('alert-success', 'Profile ' . $statusMessage . ' successfully');
        }
        return back()->with('alert-danger', 'Something went wrong, update selected profiles');
    }

    public function deleteProfile(Request $request)
    {
        $profileId = $request->deleteProfileId;
        $reportCheck = isset($request->reportCheck) ? $request->reportCheck : 0;

        if ($profileId != '') {
            $this->profilePostService->deleteProfile($profileId, $reportCheck);
            return back()->with('alert-success', 'Profile deleted successfully');
        }
        return back()->with('alert-danger', 'Something went wrong');
    }
}
