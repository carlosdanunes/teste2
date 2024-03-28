<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('verify:profit-crash')->everyFiveMinutes();
        $schedule->command('clean:fake-bets-crash')->daily();
        $schedule->command('clean:fake-bets-double')->daily();

//        $schedule->command('email:deposit-days-notify')->daily();
        //$schedule->command('email:first-deposit-notify')->everyMinute();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
