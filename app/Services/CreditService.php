<?php

namespace App\Services;

use App\Models\User;

class CreditService
{
    const UNLOCK_COST = 5;

    public function hasEnoughCredits(User $user, int $cost = self::UNLOCK_COST): bool
    {
        return $user->credits >= $cost;
    }

    public function deductCredits(User $user, int $cost = self::UNLOCK_COST): void
    {
        $user->credits -= $cost;
        $user->save();
    }
}
