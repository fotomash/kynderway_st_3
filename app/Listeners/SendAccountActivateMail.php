<?php

namespace App\Listeners;

use App\Events\AccountActivate;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Mail\StatusChangeToActivate;
use Mail;

class SendAccountActivateMail
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
     * @param  AccountActivate  $event
     * @return void
     */
    public function handle(AccountActivate $event)
    {
        $subject = 'Your Account has been reactivated';
        $senddetails = [
            'userName' => $event->user->name . " " . $event->user->last_name,
            'activationValue' => "account",
        ];
        Mail::to($event->user->email)->send(new StatusChangeToActivate($subject, $senddetails));
    }
}
