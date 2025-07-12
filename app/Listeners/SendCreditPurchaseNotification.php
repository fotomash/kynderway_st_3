<?php

namespace App\Listeners;

use App\Events\CreditsPurchased;
use App\Notifications\CreditsPurchasedNotification;

class SendCreditPurchaseNotification
{
    public function handle(CreditsPurchased $event): void
    {
        $event->user->notify(new CreditsPurchasedNotification($event->package, $event->amount));
    }
}
