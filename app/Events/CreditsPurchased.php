<?php

namespace App\Events;

use App\Models\User;
use App\Models\CreditPackage;
use App\Models\CreditTransaction;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CreditsPurchased
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public User $user,
        public CreditPackage $package,
        public int $amount,
        public CreditTransaction $transaction
    ) {
    }
}
