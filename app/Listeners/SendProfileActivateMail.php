<?php

namespace App\Listeners;

use App\Events\ProfileActivate;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Mail\StatusChangeToActivate;

use Mail;

class SendProfileActivateMail
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ProfileActivate  $event
     * @return void
     */
    public function handle(ProfileActivate $event)
    {
        $subject = 'Your Profile has been reactivated';
        $senddetails = [
            'userName' => $event->profile_post->userdetails->name . " " . $event->profile_post->userdetails->last_name,
            'activationValue' => "profile",
        ];
        Mail::to($event->profile_post->userdetails->email)->send(new StatusChangeToActivate($subject, $senddetails));
    }
}
