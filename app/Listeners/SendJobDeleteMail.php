<?php

namespace App\Listeners;

use App\Events\JobDelete;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Mail\JobProfileDelete;

use Mail;

class SendJobDeleteMail
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
     * @param  JobDelete  $event
     * @return void
     */
    public function handle(JobDelete $event)
    {
        $senddetails = [
            'userName' => $event->job_post->userdetails->name . " " . $event->job_post->userdetails->last_name,
            'setDeletedValue' => "job post",
        ];
        Mail::to($event->job_post->userdetails->email)->send(new JobProfileDelete($senddetails));
    }
}
