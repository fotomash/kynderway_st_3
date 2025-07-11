<?php

namespace App\Services;

use App\Models\User;
use App\Models\CreditPackage;
use App\Models\CreditTransaction;
use App\Models\UnlockedProfile;
use App\Models\UserCredit;
use App\Notifications\CreditsPurchasedNotification;
use App\Notifications\ProfileUnlockedNotification;
use Illuminate\Support\Facades\DB;

class CreditService
{
    public function purchaseCredits(User $user, CreditPackage $package, $paymentMethod)
    {
        return DB::transaction(function () use ($user, $package, $paymentMethod) {
            $totalCredits = $package->credits + $package->bonus_credits;

            $credits = $user->credits()->firstOrCreate([]);
            $credits->increment('balance', $totalCredits);
            $credits->increment('lifetime_purchased', $totalCredits);
            $credits->update(['last_purchase_at' => now()]);

            $transaction = CreditTransaction::create([
                'user_id' => $user->id,
                'type' => 'purchase',
                'amount' => $totalCredits,
                'balance_after' => $credits->balance,
                'description' => "Purchased {$package->name}",
                'reference_type' => 'credit_package',
                'reference_id' => $package->id,
            ]);

            if (class_exists(CreditsPurchasedNotification::class)) {
                $user->notify(new CreditsPurchasedNotification($package, $totalCredits));
            }

            return $transaction;
        });
    }

    public function unlockProfile(User $parent, User $nanny, string $unlockType = 'full')
    {
        $creditCost = $this->getUnlockCost($unlockType);
        $credits = $parent->credits()->first();

        if (!$credits || $credits->balance < $creditCost) {
            throw new \Exception('Insufficient credits');
        }

        return DB::transaction(function () use ($parent, $nanny, $creditCost, $unlockType, $credits) {
            $credits->decrement('balance', $creditCost);
            $credits->increment('lifetime_used', $creditCost);

            $transaction = CreditTransaction::create([
                'user_id' => $parent->id,
                'type' => 'use',
                'amount' => -$creditCost,
                'balance_after' => $credits->balance,
                'description' => "Unlocked {$nanny->name}'s profile",
                'reference_type' => 'profile_unlock',
                'reference_id' => $nanny->id,
            ]);

            $unlock = UnlockedProfile::create([
                'parent_id' => $parent->id,
                'nanny_id' => $nanny->id,
                'credits_used' => $creditCost,
                'unlocked_at' => now(),
                'expires_at' => $unlockType === 'temporary' ? now()->addDays(7) : null,
            ]);

            if (class_exists(ProfileUnlockedNotification::class)) {
                $nanny->notify(new ProfileUnlockedNotification($parent));
            }

            return $unlock;
        });
    }

    public function isProfileUnlocked(User $parent, User $nanny): bool
    {
        return UnlockedProfile::where('parent_id', $parent->id)
            ->where('nanny_id', $nanny->id)
            ->where(function ($q) {
                $q->whereNull('expires_at')->orWhere('expires_at', '>', now());
            })
            ->exists();
    }

    public function getCreditPackages()
    {
        return CreditPackage::where('is_active', true)
            ->orderBy('credits')
            ->get()
            ->map(function ($package) {
                $package->savings_percentage = $this->calculateSavings($package);
                return $package;
            });
    }

    public function getRecommendedPackage(User $user)
    {
        $avgMonthlyUsage = CreditTransaction::where('user_id', $user->id)
            ->where('type', 'use')
            ->where('created_at', '>', now()->subMonths(3))
            ->avg('amount');

        $recommendedCredits = abs($avgMonthlyUsage * 1.5);

        return CreditPackage::where('is_active', true)
            ->where('credits', '>=', $recommendedCredits)
            ->orderBy('credits')
            ->first();
    }

    private function getUnlockCost(string $unlockType): int
    {
        $costs = [
            'message_only' => 1,
            'temporary' => 3,
            'full' => 5,
        ];

        return $costs[$unlockType] ?? 5;
    }

    private function calculateSavings(CreditPackage $package)
    {
        if (!$package->price_per_credit) {
            return 0;
        }

        $basePrice = $package->credits * $package->price_per_credit;
        if ($basePrice == 0) {
            return 0;
        }
        return round((($basePrice - $package->price) / $basePrice) * 100, 2);
    }
}
