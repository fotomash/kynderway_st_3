<?php

namespace App\Helpers;

use Chatify\Http\Models\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Config;
use App\Models\Job_Posts;
use App\Models\Profile_Posts;
use App\Models\User;
use App\Models\User_Connections;
use App\Mail\GetVerifiedProvider;
use App\Mail\JobProfileDelete;
use App\Mail\NewMessage;
use App\Mail\ProviderConnectApproval;
use App\Mail\StatusChangeToActivate;
use App\Mail\StatusChangeToSuspend;
use App\Mail\UserAccountDelete;
use App\Mail\AccountDeleteAdmin;
use App\Mail\ConnectApproval;

class EmailHelper
{
    public static function deleteAccountMail($user, $type = 'Hard')
    {
        Mail::to($user->email)->send(new UserAccountDelete([
            'firstName' => $user->name,
            'lastName' => $user->last_name,
            'type' => $type,
        ]));

        $adminEmail = Config::get('kinderway.emailOptions.adminEmail');
        $data = [
            'firstName' => $user->name,
            'lastName' => $user->last_name,
            'email' => $user->email,
            'type' => ($user->type == 'service_seeker') ? $user->client_type : 'Provider'
        ];
        Mail::to($adminEmail)->send(new AccountDeleteAdmin($data));
    }

    public static function approveConnectionMail($connectid)
    {
        if ($connectid != '') {
            $connectionDetails = User_Connections::where('id', $connectid)->with('job', 'jobProvider', 'jobPoster')->first();

            $sendMailTo = $connectionDetails->jobProvider['email'];
            $senddetails = [
                'jobTitle' => $connectionDetails->job['jobtitle'],
                'providerName' => $connectionDetails->jobProvider['name'],
                'jobPosterName' => $connectionDetails->jobPoster['name'],
            ];

            Mail::to($sendMailTo)->send(new ProviderConnectApproval($senddetails));
        }
    }

    public static function approveConnectionMailFromProvider($connectid)
    {
        if ($connectid != '') {
            $connectionDetails = User_Connections::where('id', $connectid)->with('job', 'jobProvider', 'jobPoster')->first();
            $clientType = $connectionDetails->jobPoster['client_type'];
            $dashboardUrl = ($clientType == 'Business') ? 'user/client/dashboard' : 'user/client/dashboard';

            $sendMailTo = $connectionDetails->jobPoster['email'];
            $senddetails = [
                'jobTitle' => $connectionDetails->job['jobtitle'],
                'providerName' => $connectionDetails->jobProvider['name'],
                'jobPosterName' => $connectionDetails->jobPoster['name'],
                'dashboardUrl' => $dashboardUrl,
            ];

            Mail::to($sendMailTo)->send(new ConnectApproval($senddetails));
        }
    }

    public static function verificationRequestMailToProvider()
    {
        $providerId = Auth::user()->id;
        if ($providerId != '') {
            $providerDetails = User::where('id', $providerId)->first();

            $sendMailTo = $providerDetails['email'];
            $senddetails = [
                'providerName' => $providerDetails['name'],
            ];

            Mail::to($sendMailTo)->send(new GetVerifiedProvider($senddetails));
        }
    }

    public static function jobOrProfileDeleteMail($id, $deletedValue)
    {
        if ($id != '') {
            if ($deletedValue == 'Job') {
                $jobDetails = Job_Posts::with('userdetails')->where('id', $id)->first();
                $sendMailTo = $jobDetails->userdetails['email'];
                $senddetails = [
                    'userName' => $jobDetails->userDetails['name'] . ' ' . $jobDetails->userDetails['last_name'],
                    'setDeletedValue' => 'job post',
                ];
                $subject = 'Your account job post has been deleted';
            }
            if ($deletedValue == 'Profile') {
                $jobDetails = Profile_Posts::with('userdetails')->where('id', $id)->first();
                $sendMailTo = $jobDetails->userdetails['email'];
                $senddetails = [
                    'userName' => $jobDetails->userDetails['name'] . ' ' . $jobDetails->userDetails['last_name'],
                    'setDeletedValue' => 'profile',
                ];
                $subject = 'Your account profile has been deleted';
            }

            Mail::to($sendMailTo)->send(new JobProfileDelete($senddetails));
        }
    }

    public static function unreadMessageMail($data)
    {
        if (!empty($data)) {
            $sendMailTo = $data['toEmail'];
            Mail::to($sendMailTo)->send(new NewMessage($data));
        }
    }

    public static function changesStatusSuspendMail($id, $suspensionType)
    {
        if ($id != '') {
            if ($suspensionType == 'User') {
                $userDetails = User::where('id', $id)->first();
                $sendMailTo = $userDetails['email'];
                $senddetails = [
                    'userName' => $userDetails['name'] . ' ' . $userDetails['last_name'],
                    'suspensionValue' => '',
                ];
                $subject = 'Your account has been suspended';
            } elseif ($suspensionType == 'Job') {
                $jobDetails = Job_Posts::with('userdetails')->where('id', $id)->first();
                $sendMailTo = $jobDetails->userdetails['email'];
                $senddetails = [
                    'userName' => $jobDetails->userDetails['name'] . ' ' . $jobDetails->userDetails['last_name'],
                    'suspensionValue' => 'job post',
                ];
                $subject = 'Your account job post has been suspended';
            } elseif ($suspensionType == 'Profile') {
                $jobDetails = Profile_Posts::with('userdetails')->where('id', $id)->first();
                $sendMailTo = $jobDetails->userdetails['email'];
                $senddetails = [
                    'userName' => $jobDetails->userDetails['name'] . ' ' . $jobDetails->userDetails['last_name'],
                    'suspensionValue' => 'profile',
                ];
                $subject = 'Your account profile has been suspended';
            }

            Mail::to($sendMailTo)->send(new StatusChangeToSuspend($senddetails));
        }
    }

    public static function changesStatusActivateMail($id, $activationType)
    {
        if ($id != '') {
            if ($activationType == 'User') {
                $userDetails = User::where('id', $id)->first();
                $sendMailTo = $userDetails['email'];
                $senddetails = [
                    'userName' => $userDetails['name'] . ' ' . $userDetails['last_name'],
                    'activationValue' => 'account',
                ];
                $subject = 'Your Account has been reactivated';
            } elseif ($activationType == 'Job') {
                $jobDetails = Job_Posts::with('userdetails')->where('id', $id)->first();
                $sendMailTo = $jobDetails->userdetails['email'];
                $senddetails = [
                    'userName' => $jobDetails->userDetails['name'] . ' ' . $jobDetails->userDetails['last_name'],
                    'activationValue' => 'job post',
                ];
                $subject = 'Your Job has been reactivated';
            } elseif ($activationType == 'Profile') {
                $profileDetails = Profile_Posts::with('userdetails')->where('id', $id)->first();
                $sendMailTo = $profileDetails->userdetails['email'];
                $senddetails = [
                    'userName' => $profileDetails->userDetails['name'] . ' ' . $profileDetails->userDetails['last_name'],
                    'activationValue' => 'profile',
                ];
                $subject = 'Your Profile has been reactivated';
            }

            Mail::to($sendMailTo)->send(new StatusChangeToActivate($subject, $senddetails));
        }
    }
}

