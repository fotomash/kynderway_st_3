<?php

namespace App\Helpers;

use Chatify\Http\Models\Message;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

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

use App\Mail\GetVerifiedProvider;
use App\Mail\JobProfileDelete;
use App\Mail\NewMessage;
use App\Mail\ProviderConnectApproval;
use App\Mail\StatusChangeToActivate;
use App\Mail\StatusChangeToSuspend;
use App\Mail\UserAccountDelete;
use App\Mail\AccountDeleteAdmin;
use App\Mail\ConnectApproval;

use Config;
use Storage;

class Helper
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
            $getCount = User_Connections::where('jobappliedid', $id)->count();
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

        // dd(isset($user->phone) && trim($user->phone) !== '');
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
                $tempArr = $getValue->toArray();
                $arr[] = $tempArr['name'];
            } elseif ($modelValue == 'position') {
                $getValue = Experiences::where('id', $explodeValue[$i])->first();
                $tempArr = $getValue->toArray();
                $arr[] = $tempArr['exp_name'];
            } elseif ($modelValue == 'jobtypes') {
                $getValue = Job_Types::where('id', $explodeValue[$i])->first();
                $tempArr = $getValue->toArray();
                $arr[] = $tempArr['jobtype'];
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
            $cntjt = 0;
            $alljobtypes = [];
            $alljobtypes = explode(",", $jobtypes);
            $cntjt = count($alljobtypes);
            foreach ($alljobtypes as $key => $value) {
                $tempjobtype = Job_Types::find($value)->jobtype;
                if ($cntjt > 1) {
                    $thisjobtype .= $tempjobtype . ",";
                } else {
                    $thisjobtype .= $tempjobtype;
                }
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
                    //Get provider name:
                    $providerName = User::find($reportedConnection[$i]['provider_id'])->name;
                    (count($reportedConnection) > 1) ? $reportProviders .= $providerName . "," : $reportProviders .= $providerName;
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
        //Soft Delete jobs
        if ($user->type == 'service_seeker') {
            //Soft delete message:----
            $messageDeleteFrom = Message::where('from_id', $user->id)->delete();
            $messageDeleteTo = Message::where('to_id', $user->id)->delete();

            //Soft delete connections:
            User_Connections::where('job_userid', $user->id)->delete();

            //Soft delete userjobs:
            $jobs = Job_Posts::where('user_id', $user->id)->get();
            foreach ($jobs as $job) {
                $reports = $job->reports;
                foreach ($reports as $report) {
                    $report->reportUsers()->delete();
                }
                $job->reports()->delete();
            }
            $jobDelete = Job_Posts::where('user_id', $user->id)->delete();
        } else { //Provider details soft delete:
            //Other languages table:
            User_Language::where('user_id', $user->id)->delete();

            //Soft delete video:
            $video = Videointros::where('provider_id', $user->id)->first();
            if ($video != null && $video->videofile != '' && file_exists(storage_path('app/public/' . $video->videofile))) {
                unlink(storage_path('app/public/' . $video->videofile));
                $video->delete();
            }
            //Soft delete verified:
            $verify = Getverified::where('provider_id', $user->id)->first();
            if ($verify && $verify->identification_doc != '' && file_exists(storage_path('app/public/' . $verify->identification_doc))) {
                unlink(storage_path('app/public/' . $verify->identification_doc));
                $verify->delete();
            }
            //Soft delete message:----
            Message::where('from_id', $user->id)->delete();
            Message::where('to_id', $user->id)->delete();

            //Soft delete connections:
            User_Connections::where('provider_id', $user->id)->delete();

            //Soft delete provider profile:
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

    public static function deleteAccountMail($user, $type = 'Hard')
    {
        //Message to User:--------
        Mail::to($user->email)->send(new UserAccountDelete([
            'firstName' => $user->name,
            'lastName' => $user->last_name,
            'type' => $type,
        ]));

        //Message to Admin:--------
        $adminEmail =  Config::get('kinderway.emailOptions.adminEmail');
        $data = [
            'firstName' => $user->name,
            'lastName' => $user->last_name,
            'email' => $user->email,
            'type' => ($user->type == 'service_seeker') ? $user->client_type : 'Provider'
        ];
        Mail::to($adminEmail)->send(new AccountDeleteAdmin($data));
    }

    /*Mail to Provider on business/individual connect approval*/
    public static function approveConnectionMail($connectid)
    {
        if ($connectid != '') {
            //Get provider and ind/business details:
            $connectionDetails = User_Connections::where('id', $connectid)->with('job', 'jobProvider', 'jobPoster')->first();

            //Send mail:
            $sendMailTo = $connectionDetails->jobProvider['email'];
            $senddetails = [
                'jobTitle' => $connectionDetails->job['jobtitle'],
                // 'providerName' => $connectionDetails->jobProvider['name']." ".$connectionDetails->jobProvider['last_name'],
                // 'jobPosterName' => $connectionDetails->jobPoster['name']." ".$connectionDetails->jobPoster['last_name'],
                'providerName' => $connectionDetails->jobProvider['name'],
                'jobPosterName' => $connectionDetails->jobPoster['name'],
            ];


            Mail::to($sendMailTo)->send(new ProviderConnectApproval($senddetails));
            // Mail::send('emails.provider-connect-approval', $senddetails, function ($message) use ($sendMailTo)
            // {
            //     $message->to($sendMailTo)->subject('Your Application has been accepted');
            // });
        }
    }

    /*Mail to business/individual on provider connect approval*/
    public static function approveConnectionMailFromProvider($connectid)
    {
        if ($connectid != '') {
            //Get provider and ind/business details:
            $connectionDetails = User_Connections::where('id', $connectid)->with('job', 'jobProvider', 'jobPoster')->first();
            $clientType = $connectionDetails->jobPoster['client_type'];
            $dashboardUrl = ($clientType == 'Business') ? 'user/client/dashboard' : 'user/client/dashboard';

            //Send mail:
            $sendMailTo = $connectionDetails->jobPoster['email'];
            $senddetails = [
                'jobTitle' => $connectionDetails->job['jobtitle'],
                // 'providerName' => $connectionDetails->jobProvider['name']." ".$connectionDetails->jobProvider['last_name'],
                // 'jobPosterName' => $connectionDetails->jobPoster['name']." ".$connectionDetails->jobPoster['last_name'],
                'providerName' => $connectionDetails->jobProvider['name'],
                'jobPosterName' => $connectionDetails->jobPoster['name'],
                'dashboardUrl' => $dashboardUrl,
            ];

            Mail::to($sendMailTo)->send(new ConnectApproval($senddetails));
            // Mail::send('emails.connect-approval', $senddetails, function ($message) use ($sendMailTo)
            // {
            //     $message->to($sendMailTo)->subject('Your Invitation has been accepted');
            // });
        }
    }

    public static function softDeleteAllJobs($jobId, $by)
    {
        //Soft delete message:----
        //Get all message of job, soft delete user message:
        $jobConnections = User_Connections::where('jobappliedid', $jobId)->get()->toArray();
        foreach ($jobConnections as $jobConnection) {
            //Soft delete message by connection id:
            $messageDelete = Message::where('reference_id', $jobConnection['id']);
            $messageDelete->delete();
        }
        //----------------------------

        //Soft delete connections:
        $connectionDelete = User_Connections::where('jobappliedid', $jobId);
        $connectionDelete->delete();
        //-----------------------

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
    
                // Sum the counts
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

    public static function verificationRequestMailToProvider()
    {
        $providerId = Auth::user()->id;
        if ($providerId != '') {
            //Get provider details:
            $providerDetails = User::where('id', $providerId)->first();

            //Send mail:
            $sendMailTo = $providerDetails['email'];
            $senddetails = [
                // 'providerName' => $providerDetails['name']." ".$providerDetails['last_name'],
                'providerName' => $providerDetails['name'],
            ];

            Mail::to($sendMailTo)->send(new GetVerifiedProvider($senddetails));
        }
    }

    /*Send mail on job/profile deletion*/
    public static function jobOrProfileDeleteMail($id, $deletedValue)
    {
        if ($id != '') {
            if ($deletedValue == 'Job') {
                $jobDetails = Job_Posts::with('userdetails')->where('id', $id)->first();
                $sendMailTo = $jobDetails->userdetails['email'];
                $senddetails = [
                    'userName' => $jobDetails->userDetails['name'] . " " . $jobDetails->userDetails['last_name'],
                    'setDeletedValue' => "job post",
                ];
                $subject = 'Your account job post has been deleted';
            }
            if ($deletedValue == 'Profile') {
                $jobDetails = Profile_Posts::with('userdetails')->where('id', $id)->first();
                $sendMailTo = $jobDetails->userdetails['email'];
                $senddetails = [
                    'userName' => $jobDetails->userDetails['name'] . " " . $jobDetails->userDetails['last_name'],
                    'setDeletedValue' => "profile",
                ];
                $subject = 'Your account profile has been deleted';
            }


            Mail::to($sendMailTo)->send(new JobProfileDelete($senddetails));
            // Mail::send('emails.job-profile-delete', $senddetails, function ($message) use ($sendMailTo,$subject)
            // {
            //     $message->to($sendMailTo)->subject($subject);
            // });
        }
    }

    /*Send mail on unread messages */
    public static function unreadMessageMail($data)
    {
        if (!empty($data)) {
            $sendMailTo = $data['toEmail'];
            $subject = 'You have a new message';

            Mail::to($sendMailTo)->send(new NewMessage($data));
            // Mail::send('emails.new-message', $data, function ($message) use ($sendMailTo, $subject)
            // {
            //     $message->to($sendMailTo)->subject($subject);
            // });
        }
    }

    /*Send mail on user Account Status Chage(Suspend)*/
    public static function changesStatusSuspendMail($id, $suspensionType)
    {
        if ($id != '') {
            if ($suspensionType == 'User') { //id=userid
                //Get User details:
                $userDetails = User::where('id', $id)->first();
                $sendMailTo = $userDetails['email'];
                $senddetails = [
                    'userName' => $userDetails['name']." ".$userDetails['last_name'],
                    'suspensionValue' => "",
                ];
                $subject = 'Your account has been suspended';
            } elseif ($suspensionType == 'Job') {
                $jobDetails = Job_Posts::with('userdetails')->where('id', $id)->first();
                $sendMailTo = $jobDetails->userdetails['email'];
                $senddetails = [
                    'userName' => $jobDetails->userDetails['name']." ".$jobDetails->userDetails['last_name'],
                    'suspensionValue' => "job post",
                ];
                $subject = 'Your account job post has been suspended';
            } elseif ($suspensionType == 'Profile') {
                $jobDetails = Profile_Posts::with('userdetails')->where('id', $id)->first();
                $sendMailTo = $jobDetails->userdetails['email'];
                $senddetails = [
                    'userName' => $jobDetails->userDetails['name']." ".$jobDetails->userDetails['last_name'],
                    'suspensionValue' => "profile",
                ];
                $subject = 'Your account profile has been suspended';
            }

            Mail::to($sendMailTo)->send(new StatusChangeToSuspend($senddetails));
            // Mail::send('emails.status-change-to-suspend', $senddetails, function ($message) use ($sendMailTo,$subject)
            // {
            //     $message->to($sendMailTo)->subject($subject);
            // });
        }
    }

    /*Send mail on user Account Status Change(Activate)*/
    public static function changesStatusActivateMail($id, $activationType)
    {
        if ($id != '') {
            if ($activationType == 'User') { //id=userid
                // Get User details:
                $userDetails = User::where('id', $id)->first();
                $sendMailTo = $userDetails['email'];
                $senddetails = [
                    'userName' => $userDetails['name'] . " " . $userDetails['last_name'],
                    'activationValue' => "account",
                ];
                $subject = 'Your Account has been reactivated';
            } elseif ($activationType == 'Job') {
                $jobDetails = Job_Posts::with('userdetails')->where('id', $id)->first();
                $sendMailTo = $jobDetails->userdetails['email'];
                $senddetails = [
                    'userName' => $jobDetails->userDetails['name'] . " " . $jobDetails->userDetails['last_name'],
                    'activationValue' => "job post",
                ];
                $subject = 'Your Job has been reactivated';
            } elseif ($activationType == 'Profile') {
                $profileDetails = Profile_Posts::with('userdetails')->where('id', $id)->first();
                $sendMailTo = $profileDetails->userdetails['email'];
                $senddetails = [
                    'userName' => $profileDetails->userDetails['name'] . " " . $profileDetails->userDetails['last_name'],
                    'activationValue' => "profile",
                ];
                $subject = 'Your Profile has been reactivated';
            }

            Mail::to($sendMailTo)->send(new StatusChangeToActivate($subject, $senddetails));
            // Mail::send('emails.status-change-to-suspend', $senddetails, function ($message) use ($sendMailTo,$subject)
            // {
            //     $message->to($sendMailTo)->subject($subject);
            // });
        }
    }

    /*report move to completed when delete activate or suspend*/
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
