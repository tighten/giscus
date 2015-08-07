<?php

namespace App\Jobs;

use App\NotifiedComment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class NotifyUserOfNewGistComment extends Job
{
    public function __construct()
    {
    }

    public function fire($job, $data)
    {
        $this->sendNotificationEmail($data['comment'], $data['gist'], $data['user']);

        $this->markCommentAsNotified($data['comment']);

        Log::info('Emailed notification for comment ' . $data['comment']['id']);

        $job->delete();
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
}
