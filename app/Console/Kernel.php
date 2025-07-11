<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\EmailMessagesCron::class,
        Commands\deleteUser::class,
        Commands\EmailMessagesCron::class,
        Commands\SecurityAudit::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        $schedule->command('email:messages')->everyTwoMinutes()->emailOutputOnFailure('murlidharfichadia@gmail.com');
        $schedule->command('delete:user')->daily()->emailOutputOnFailure('murlidharfichadia@gmail.com');
        $schedule->command('mailing:send')->everyMinute()->withoutOverlapping()->emailOutputOnFailure('bilelbho94@gmail.com');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
