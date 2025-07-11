<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use App\Mail\SuspiciousActivityAlert;

class FraudDetectionService
{
    /**
     * Check for suspicious activity for the given user.
     *
     * @param  \App\Models\User  $user
     * @return array
     */
    public function checkUserActivity(User $user): array
    {
        $flags = [];

        // Check for rapid account creation from same IP
        $recentAccounts = User::where('ip_address', $user->ip_address)
            ->where('created_at', '>', now()->subHours(24))
            ->count();

        if ($recentAccounts > 3) {
            $flags[] = 'multiple_accounts_same_ip';
        }

        // Check for unusual booking patterns
        if (method_exists($user, 'bookings')) {
            $recentBookings = $user->bookings()
                ->where('created_at', '>', now()->subHours(1))
                ->count();

            if ($recentBookings > 5) {
                $flags[] = 'rapid_booking_creation';
            }
        }

        // Check for payment anomalies
        if (method_exists($user, 'transactions')) {
            $failedPayments = $user->transactions()
                ->where('status', 'failed')
                ->where('created_at', '>', now()->subDays(7))
                ->count();

            if ($failedPayments > 10) {
                $flags[] = 'excessive_payment_failures';
            }
        }

        // Store flags and notify admin
        if (!empty($flags)) {
            Cache::put("fraud_flags:{$user->id}", $flags, now()->addDays(7));
            $this->notifyAdminOfSuspiciousActivity($user, $flags);
        }

        return $flags;
    }

    /**
     * Notify administrators when suspicious activity is detected.
     */
    protected function notifyAdminOfSuspiciousActivity(User $user, array $flags): void
    {
        $adminEmail = Config::get('kinderway.emailOptions.adminEmail');

        Mail::to($adminEmail)->send(new SuspiciousActivityAlert([
            'user' => $user,
            'flags' => $flags,
        ]));
    }
}
