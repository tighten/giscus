<?php

namespace App\Console;

use App\Jobs\NotifyUserOfNewGistComments;
use App\User;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Queue;

class Kernel extends ConsoleKernel
{
    use DispatchesJobs;

    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\Inspire::class,
        \App\Console\Commands\ClearBeanstalkdQueueCommand::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule
            ->call(function () {
                Log::info('Cron start');

                User::all()->each(function ($user) {
                    $this->dispatch(new NotifyUserOfNewGistComments($user));
                });

                Log::info('Cron stop');
            })
            ->hourly();
            // ->sendOutputTo(storage_path('cron-or-something'))
            // ->emailOutputTo(env('MAIL_FROM_EMAIL'));
    }
}
