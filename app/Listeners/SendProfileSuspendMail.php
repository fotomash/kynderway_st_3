<?php

namespace App\Listeners;

use App\Events\ProfileSuspend;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Mail\StatusChangeToSuspend;

use Mail;

class SendProfileSuspendMail
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
     * @param  ProfileSuspend  $event
     * @return void
     */
    public function handle(ProfileSuspend $event)
    {
        $senddetails = [
            'userName' => $event->profile_post->userdetails->name . " " . $event->profile_post->userdetails->last_name,
            'suspensionValue' => "profile",
        ];
        Mail::to($event->profile_post->userdetails->email)->send(new StatusChangeToSuspend($senddetails));
    }
}
