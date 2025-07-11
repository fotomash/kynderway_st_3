<?php

namespace App\Services;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class PushNotificationService
{
    private $messaging;

    public function __construct()
    {
        $firebase = (new Factory)->withServiceAccount(config('firebase.credentials'));
        $this->messaging = $firebase->createMessaging();
    }

    public function notifyNannyOfNewJob($nanny, $jobPost)
    {
        $message = CloudMessage::withTarget('token', $nanny->fcm_token)
            ->withNotification(Notification::create(
                'New Job Match!',
                "A new job matching your profile has been posted in {$jobPost->city}"
            ))
            ->withData([
                'job_id' => $jobPost->id,
                'type' => 'new_job',
            ]);

        $this->messaging->send($message);
    }

    public function notifyParentOfApplication($parent, $application)
    {
        $message = CloudMessage::withTarget('token', $parent->fcm_token)
            ->withNotification(Notification::create(
                'New Application',
                "{$application->nanny->name} has applied to your job posting"
            ))
            ->withData([
                'application_id' => $application->id,
                'type' => 'new_application',
            ]);

        $this->messaging->send($message);
    }
}
