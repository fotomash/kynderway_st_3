<?php

namespace App\Listeners;

use App\Events\UserVerificationRejected as EventUserVerificationRejected;
use App\Mail\UserVerificationRejected;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use Mail;

class SendUserVerificationRejectedMail
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
     * @param  EventUserVerificationRejected  $event
     * @return void
     */
    public function handle(EventUserVerificationRejected $event)
    {
        $senddetails = [
            'providerName' => $event->user->name,
        ];
        Mail::to($event->user->email)->send(new UserVerificationRejected($senddetails));
    }
}
