<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    use DispatchesJobs;

    protected $commands = [
        Commands\QueueCommentsForUser::class,
        Commands\QueueCommentsForAllUsers::class,
    ];

    protected function schedule(Schedule $schedule)
    {
        // Disabled. No need anymore! https://github.blog/changelog/2019-06-03-authors-subscribed-to-gists/
        // $schedule
        //     ->command('giscus:queueForUsers')
        //     ->everyThirtyMinutes();

        // $schedule->command('horizon:snapshot')->everyFiveMinutes();
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
