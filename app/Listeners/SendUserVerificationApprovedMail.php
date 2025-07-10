<?php

namespace App\Listeners;

use App\Events\UserVerificationApproved as EventUserVerificationApproved;
use App\Mail\UserVerificationApproved;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use Mail;

class SendUserVerificationApprovedMail
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
     * @param  EventUserVerificationApproved  $event
     * @return void
     */
    public function handle(EventUserVerificationApproved $event)
    {
        $senddetails = [
            'providerName' => $event->user->name,
        ];
        Mail::to($event->user->email)->send(new UserVerificationApproved($senddetails));
    }
}
