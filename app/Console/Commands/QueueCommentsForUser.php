<?php

namespace App\Console\Commands;

use App\Jobs\NotifyUserOfNewGistComments;
use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\DispatchesJobs;

class QueueCommentsForUser extends Command
{
    use DispatchesJobs;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'giscus:queueForUser {user}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Queue the comment pull for a user.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->dispatch(
            new NotifyUserOfNewGistComments(
                \App\User::find($this->argument('user'))
            )
        );
    }
}
