<?php

namespace App\Console\Commands;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class deleteUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete user after 72 hours if not verified';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $users = User::whereNull('email_verified_at')
            ->where('created_at', '<', Carbon::now()->subDays(3)->toDateTimeString())
            ->get();
        foreach ($users as $user) {
            $user->forceDelete();
        }

        $this->info('Not verified user deleted successfully.');
    }
}
