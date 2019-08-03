<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;
use App\Jobs\NotifyUserOfNewGistComments;
use Illuminate\Foundation\Bus\DispatchesJobs;

class QueueCommentsForUser extends Command
{
    use DispatchesJobs;

    protected $signature = 'giscus:queueForUser {user}';

    protected $description = 'Queue the comment pull for a user.';

    public function handle()
    {
        $this->dispatch(
            new NotifyUserOfNewGistComments(
                User::find($this->argument('user'))
            )
        );
    }
}
