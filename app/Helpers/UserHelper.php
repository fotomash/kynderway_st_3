<?php

namespace App\Helpers;

use Chatify\Http\Models\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Job_Posts;
use App\Models\Profile_Posts;
use App\Models\Report;
use App\Models\ReportUser;
use App\Models\User;
use App\Models\Specialities;
use App\Models\Experiences;
use App\Models\Job_Types;
use App\Models\Getverified;
use App\Models\Videointros;
use App\Models\User_Language;
use App\Models\User_Connections;
use App\Models\DocumentUser;

class UserHelper
{
    public static function getUserName($id)
    {
        if ($id != '') {
            $getName = User::select('name', 'last_name')
                ->where('id', $id)->first();
            $userName = $getName['name'];
            return $userName;
        }
    }

    public static function getApplicantsCount($id)
    {
        if ($id != '') {
            $results = \DB::table('user_connections')
                ->where('jobappliedid', '=', $id)
                ->count();
            return $results;
        }
    }

    public static function hasWorkProfile()
    {
        $userId = Auth::id();
        return Profile_Posts::where('provider_id', $userId)->exists();
    }

    public static function countWorkProfiles()
    {
        $userId = Auth::id();
        $count = Profile_Posts::where('provider_id', $userId)->count();

        if ($count == 1) {
            return 'first';
        } elseif ($count == 2) {
            return 'second';
        } elseif ($count == 3) {
            return 'third';
        } elseif ($count == 4) {
            return 'fourth';
        } else {
            return $count;
        }
    }

    public static function hasProfile()
    {
        $userId = Auth::id();
        $user = User::find($userId);

        return isset($user->phone) && trim($user->phone) !== '';
    }

    public static function getProfilePic($id)
    {
        if ($id != '') {
            $profilePicture = '/website/images/resources/default-dp.jpg';
            $getPic = User::select('profile_picture')
                ->where('id', $id)->first();

            if ($getPic != null && $getPic['profile_picture'] != '') {
                $profilePicture = '/storage/' . $getPic['profile_picture'];
            }
            return $profilePicture;
        }
    }

    public static function getIcon($categoryid)
    {
        $iconVal = '';
        if ($categoryid == '1') {
            $iconVal = '/assets/media/categories/white/Asset 12@2x.png';
        } elseif ($categoryid == '2') {
            $iconVal = '/assets/media/categories/white/Asset 9@2x.png';
        } elseif ($categoryid == '3') {
            $iconVal = 'flaticon-elderly';
        } elseif ($categoryid == '4') {
            $iconVal = 'flaticon-pawprint-outline-in-a-circle';
        } elseif ($categoryid == '5') {
            $iconVal = '/assets/media/categories/white/Asset 8@2x.png';
        } elseif ($categoryid == '6') {
            $iconVal = '/assets/media/categories/white/Asset 3@2x.png';
        } elseif ($categoryid == '7') {
            $iconVal = 'flaticon-reading';
        }

        return $iconVal;
    }

    public static function getValuesForIds($modelValue, $databaseValue)
    {
        $arr = [];
        $explodeValue = explode(',', $databaseValue);
        for ($i = 0; $i < count($explodeValue); $i++) {
            if ($modelValue == 'workwith') {
                $getValue = Specialities::where('id', $explodeValue[$i])->first();
                $arr[] = $getValue->name;
            } elseif ($modelValue == 'position') {
                $getValue = Experiences::where('id', $explodeValue[$i])->first();
                $arr[] = $getValue->exp_name;
            } elseif ($modelValue == 'jobtypes') {
                $getValue = Job_Types::where('id', $explodeValue[$i])->first();
                $arr[] = $getValue->jobtype;
            }
        }
        return $arr;
    }

    public static function getProfileImage($imageValue)
    {
        $profilePicture = '/website/images/resources/default-dp.jpg';
        if ($imageValue != '') {
            $profilePicture = '/storage/' . $imageValue;
        }
        return $profilePicture;
    }

    public static function getProviderJobType($jobtypes)
    {
        $thisjobtype = '';
        if ($jobtypes != '') {
            $alljobtypes = explode(',', $jobtypes);
            foreach ($alljobtypes as $value) {
                $tempjobtype = Job_Types::find($value)->jobtype;
                $thisjobtype .= $tempjobtype . ',';
            }
            if ($thisjobtype != '') {
                $thisjobtype = rtrim($thisjobtype, ',');
            }
        }
        return $thisjobtype;
    }

    public static function getReportedProviderName($reportedConnection)
    {
        $reportProviders = '';
        if ($reportedConnection != '') {
            for ($i = 0; $i < count($reportedConnection); $i++) {
                if ($reportedConnection[$i]['report'] == 1) {
                    $providerName = User::find($reportedConnection[$i]['provider_id'])->name;
                    (count($reportedConnection) > 1) ? $reportProviders .= $providerName . ',' : $reportProviders .= $providerName;
                }
            }

            $reportProviders = rtrim($reportProviders, ',');
        }

        return $reportProviders;
    }

    public static function deleteAccount($user)
    {
        if ($user->profile_picture != null && $user->profile_picture != '') {
            $profilePicture = '/storage/' . $user->profile_picture;
            Storage::delete($profilePicture);
        }
        if ($user->type == 'service_seeker') {
            Message::where('from_id', $user->id)->delete();
            Message::where('to_id', $user->id)->delete();
            User_Connections::where('job_userid', $user->id)->delete();
            $jobs = Job_Posts::where('user_id', $user->id)->get();
            foreach ($jobs as $job) {
                $reports = $job->reports;
                foreach ($reports as $report) {
                    $report->reportUsers()->delete();
                }
                $job->reports()->delete();
            }
            Job_Posts::where('user_id', $user->id)->delete();
        } else {
            User_Language::where('user_id', $user->id)->delete();
            $video = Videointros::where('provider_id', $user->id)->first();
            if ($video != null && $video->videofile != '' && file_exists(storage_path('app/public/' . $video->videofile))) {
                unlink(storage_path('app/public/' . $video->videofile));
                $video->delete();
            }
            $verify = Getverified::where('provider_id', $user->id)->first();
            if ($verify && $verify->identification_doc != '' && file_exists(storage_path('app/public/' . $verify->identification_doc))) {
                unlink(storage_path('app/public/' . $verify->identification_doc));
                $verify->delete();
            }
            Message::where('from_id', $user->id)->delete();
            Message::where('to_id', $user->id)->delete();
            User_Connections::where('provider_id', $user->id)->delete();
            Profile_Posts::where('provider_id', $user->id)->update(['edu_description' => '']);
            foreach ($user->profileposts as $profile) {
                $reports = $profile->reports;
                foreach ($reports as $report) {
                    $report->reportUsers()->delete();
                }
                $profile->reports()->delete();
            }
            Profile_Posts::where('provider_id', $user->id)->delete();
        }
    }

    public static function softDeleteAllJobs($jobId, $by)
    {
        $jobConnections = User_Connections::where('jobappliedid', $jobId)->get()->toArray();
        foreach ($jobConnections as $jobConnection) {
            $messageDelete = Message::where('reference_id', $jobConnection['id']);
            $messageDelete->delete();
        }
        $connectionDelete = User_Connections::where('jobappliedid', $jobId);
        $connectionDelete->delete();

        $model = Job_Posts::find($jobId);
        $model->deleted_by = $by;
        $model->save();
        $model->delete();
    }

    public static function getUnseenCount($connectionId, $userId)
    {
        $count = 0;

        if ($connectionId != '') {
            $messageCount = Message::where([
                ['reference_id', '=', $connectionId],
                ['to_id', '=', $userId]
            ])->where('seen', 0)->count();

            $userConnection = User_Connections::find($connectionId);

            if ($userConnection && Auth::user()->id == $userConnection->provider_id) {
                $documentCount = DocumentUser::where([
                    ['provider_id', '=', $userConnection->provider_id],
                    ['seeker_id', '=', $userConnection->job_userid],
                    ['is_requested', '=', 1]
                ])->count();

                $count = $messageCount + $documentCount;
            } else {
                $count = $messageCount;
            }
        }

        return $count;
    }

    public static function getTotalCount($connectionId, $userId)
    {
        $count = 0;
        if ($connectionId != '') {
            $count = Message::where([
                ['reference_id', '=', $connectionId],
                ['to_id', '=', $userId]
            ])->get()->count();
        }
        return $count;
    }

    public static function reportComplete($referenceID, $type)
    {
        if ($referenceID != '' && $type != '') {
            if ($type == 'Job') {
                $report = Report::where('job_post_id', $referenceID)
                    ->where('type', $type)
                    ->first();
                $report->status = 0;
                $report->save();
            }
            if ($type == 'Profile') {
                $report = Report::with('reportUsers')
                    ->where('profile_post_id', $referenceID)
                    ->where('type', $type)
                    ->first();
                $report->status = 0;
                $report->save();
            }

            ReportUser::where('report_id', $report->id)->update(['status' => 0]);
        } else {
            return false;
        }
    }
}
