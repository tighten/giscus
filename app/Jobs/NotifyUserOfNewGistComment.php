<?php

namespace App\Jobs;

use App\NotifiedComment;
use Carbon\Carbon;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class NotifyUserOfNewGistComment extends Job implements SelfHandling, ShouldQueue
{
    private $user;
    private $comment;
    private $gist;

    use InteractsWithQueue, SerializesModels;

    public function __construct($user, $comment, $gist)
    {
        $this->user = $user;
        $this->comment = $comment;
        $this->gist = $gist;
    }

    public function handle()
    {
        if ($this->commentNoLongerNeedsNotification()) {
            Log::info(sprintf(
                'Skipped emailing notification for comment %s because it no longer needs notification.',
                $this->comment['id']
            ));

            return true;
        }

        $this->sendNotificationEmail($this->comment, $this->gist, $this->user);

        $this->markCommentAsNotified($this->comment);

        Log::info('Emailed notification for comment ' . $this->comment['id']);
    }

    private function sendNotificationEmail($comment, $gist, $user)
    {
        Mail::send(
            'emails.new-comment',
            [
                'comment' => $comment,
                'gist' => $gist,
                'user' => $user
            ],
            function ($message) use ($user) {
                $message
                    ->to($user->email, $user->name)
                    ->subject('You have a new Gist Comment!');
            }
        );
    }

    private function markCommentAsNotified($comment)
    {
        $eloquentComment = NotifiedComment::firstOrNew([
            'github_id' => $comment['id']
        ]);

        $eloquentComment->github_updated_at = Carbon::createFromFormat('Y-m-d\TH:i:s\Z', $comment['updated_at']);

        $eloquentComment->save();
    }

    private function commentNoLongerNeedsNotification()
    {
        return NotifiedComment::where('github_id', $this->comment['id'])
            ->where('github_updated_at', $this->comment['updated_at'])
            ->count() > 0;
    }
}
