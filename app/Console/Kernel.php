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
        // $schedule->command('inspire')->hourly();

        // Enable script di bawah jika real
        // $schedule->call('App\Http\Controllers\HomeController@sendEmailClose')->daily();

        // Enable script di bawah untuk test
        //$schedule->call('App\Http\Controllers\HomeController@sendEmailClose')->everyMinute();
        $schedule->command('app:cancel-order')
         ->withoutOverlapping()
         ->environments(['local', 'production'])
         ->everyMinute();
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
