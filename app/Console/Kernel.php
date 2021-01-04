<?php

namespace App\Console;

use App\Console\Commands\Broadcasting\BroadcastCheck;
use App\Console\Commands\Broadcasting\BroadcastUpdate;
use App\Console\Commands\Broadcasting\BroadcastWatcher;
use App\Console\Commands\Tournaments\CheckStatus;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{

    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands
        = [
            BroadcastUpdate::class,
            BroadcastWatcher::class,
            BroadcastCheck::class,
            CheckStatus::class,

        ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     *
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        /*** Check Stream ***/
        $schedule->command('broadcast:check')->everyFiveMinutes();
        /*** Watch Stream ***/
//        $schedule->command('broadcast:watch')->hourly();
        /*** Check Tourney ***/
        $schedule->command('tourney:check')->everyMinute();
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
