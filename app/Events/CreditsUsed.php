<?php

namespace App\Events;

use App\Models\User;
use App\Models\CreditTransaction;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CreditsUsed
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public User $user,
        public int $amount,
        public ?CreditTransaction $transaction = null
    ) {
    }
}
