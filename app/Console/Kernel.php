<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\LeavesEntitlement;
use App\Console\Commands\UpdateUnclaimedMonthlyLeaves;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
        Commands\LeavesEntitlement::class,
        Commands\UpdateUnclaimedMonthlyLeaves::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
        $schedule->command('leaves:entitlement')->daily()
                 ->withoutOverlapping()
                 ->appendOutputTo(storage_path() .'/logs/jobs.recent');

        $schedule->command('leaves:update-monthly-unclaimed')->monthly()
                 ->withoutOverlapping()
                 ->appendOutputTo(storage_path() .'/logs/jobs.recent');
        \File::append(storage_path() . "/logs/jobs.log", \File::get(storage_path() . "/logs/jobs.recent"));
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}
