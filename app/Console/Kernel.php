<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        
        // News commands - To allow the increment of the number of older records that needs
        // to be deleted, parse a parameter to the end of the command e.g: 
        // 'news:delete-older-records 4' parsing 4 will delete records older than 4 days, 
        // but the default is set to 14 based on the specification for this challenge
        
        $schedule->command('news:delete-older-records')->daily();
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
