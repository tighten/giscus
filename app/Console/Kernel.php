<?php

namespace App\Console;

use App\Jobs\NotifyUserOfNewGistComments;
use App\User;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Queue;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\Inspire::class,
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
                User::all()->each(function ($user) {
                    Queue::push(NotifyUserOfNewGistComments::class, [
                        'user' => $user,
                        'since' => Carbon::now()->subDays(99) // means nothing right now
                    ]);
                });
            })
            ->hourly()
            ->sendOutputTo('/tmp/schedule-or-something')
            ->emailOutputTo(env('MAIL_FROM_EMAIL'));
    }
}
