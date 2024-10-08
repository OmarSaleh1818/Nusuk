<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected $commands = [
        Commands\UpdateUserOpportunityStatuses::class,
        Commands\UpdateExpiredPartnerships::class, 
    ];

    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('user-opportunity-status:update')->everyMinute();

        // $schedule->command('inspire')->hourly();
        // Schedule the new partnerships status update command
        $schedule->command('partnerships:update-expired')->daily();
    }

    /**
     * Register the commands for the application.
     */

    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }

}
