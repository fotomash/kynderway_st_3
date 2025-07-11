<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SecurityAudit extends Command
{
    protected $signature = 'security:audit';
    protected $description = 'Run security audit';

    public function handle()
    {
        $this->info('Running security audit...');

        $users_without_2fa = DB::table('users')
            ->whereNull('google2fa_secret')
            ->count();
        if ($users_without_2fa > 0) {
            $this->warn("Found {$users_without_2fa} users without 2FA enabled");
        }

        $expired_keys = DB::table('api_keys')
            ->where('expires_at', '<', now())
            ->where('last_used_at', '>', now()->subDays(7))
            ->count();
        if ($expired_keys > 0) {
            $this->error("Found {$expired_keys} expired API keys still being used");
        }

        $failed_logins = DB::table('failed_logins')
            ->where('created_at', '>', now()->subHour())
            ->count();
        if ($failed_logins > 100) {
            $this->error("High number of failed login attempts: {$failed_logins}");
        }

        $this->info('Security audit completed');
    }
}
