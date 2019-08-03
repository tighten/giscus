<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;
use App\Jobs\NotifyUserOfNewGistComments;
use Illuminate\Foundation\Bus\DispatchesJobs;

class QueueCommentsForAllUsers extends Command
{
    use DispatchesJobs;

    protected $signature = 'giscus:queueForUsers';

    protected $description = 'Queue the comment pull for all users.';

    public function handle()
    {
        User::all()->each(function ($user) {
            $this->dispatch(new NotifyUserOfNewGistComments($user));
        });
    }
}
