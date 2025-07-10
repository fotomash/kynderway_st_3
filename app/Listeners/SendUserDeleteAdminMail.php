<?php

namespace App\Listeners;

use App\Events\UserDeleteEmailAdminEvent;
use App\Mail\AccountDeleteAdmin;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use Config;
use Mail;

class SendUserDeleteAdminMail
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
     * @param  UserDeleteEmailAdminEvent  $event
     * @return void
     */
    public function handle(UserDeleteEmailAdminEvent $event)
    {
        $adminEmail =  Config::get('kinderway.emailOptions.adminEmail');
        $data = [
            'firstName' => $event->user->name,
            'lastName' => $event->user->last_name,
            'email' => $event->user->email,
            'type' => ($event->user->type == 'service_seeker') ? $event->user->client_type : 'Provider'
        ];

        Mail::to($adminEmail)->send(new AccountDeleteAdmin($data));
    }
}
