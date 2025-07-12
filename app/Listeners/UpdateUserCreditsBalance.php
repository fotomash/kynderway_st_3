<?php

namespace App\Listeners;

use App\Events\CreditsPurchased;
use App\Events\CreditsUsed;

class UpdateUserCreditsBalance
{
    public function handle($event): void
    {
        $credits = $event->user->credits()->firstOrCreate([]);

        if ($event instanceof CreditsPurchased) {
            $credits->increment('balance', $event->amount);
            $credits->increment('lifetime_purchased', $event->amount);
            $credits->update(['last_purchase_at' => now()]);
        }

        if ($event instanceof CreditsUsed) {
            $credits->decrement('balance', $event->amount);
            $credits->increment('lifetime_used', $event->amount);
        }
    }
}
