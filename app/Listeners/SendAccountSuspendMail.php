<?php

namespace App\Listeners;

use App\Events\AccountSuspend;
use App\Mail\StatusChangeToSuspend;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use Mail;

class SendAccountSuspendMail
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
     * @param  AccountSuspend  $event
     * @return void
     */
    public function handle(AccountSuspend $event)
    {
        $subject = 'Your account has been suspended';
        $senddetails = [
            'userName' => $event->user->name . " " . $event->user->last_name,
            'suspensionValue' => "",
        ];
        Mail::to($event->user->email)->send(new StatusChangeToSuspend($senddetails));
    }
}
