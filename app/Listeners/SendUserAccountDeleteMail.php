<?php

namespace App\Listeners;

use App\Events\UserAccountDeleteEvent;
use App\Mail\UserAccountDelete;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use Mail;

class SendUserAccountDeleteMail
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
     * @param  UserAccountDeleteEvent  $event
     * @return void
     */
    public function handle(UserAccountDeleteEvent $event)
    {
        Mail::to($event->user->email)->send(new UserAccountDelete([
            'firstName' => $event->user->name,
            'lastName' => $event->user->last_name,
            'type' => $event->type,
        ]));
    }
}
