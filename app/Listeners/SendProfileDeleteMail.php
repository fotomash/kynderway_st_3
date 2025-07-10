<?php

namespace App\Listeners;

use App\Events\ProfileDelete;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Mail\JobProfileDelete;

use Mail;

class SendProfileDeleteMail
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
     * @param  ProfileDelete  $event
     * @return void
     */
    public function handle(ProfileDelete $event)
    {
        $senddetails = [
            'userName' => $event->profile_post->userdetails->name . " " . $event->profile_post->userdetails->last_name,
            'setDeletedValue' => "profile",
        ];
        Mail::to($event->profile_post->userdetails->email)->send(new JobProfileDelete($senddetails));
    }
}
