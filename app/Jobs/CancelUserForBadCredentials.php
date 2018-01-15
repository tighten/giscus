<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class CancelUserForBadCredentials extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    private $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function handle()
    {
        $this->sendNotificationEmail();

        $this->deleteUser();
    }

    private function deleteUser()
    {
        Log::info('Deleting user ' . $this->user->id . ' (' . $this->user->email . ') due to broken GitHub token.');

        $this->user->delete();
    }

    private function sendNotificationEmail()
    {
        Mail::to($this->user)->send(new BrokenGitHubToken($this->user));
    }
}
