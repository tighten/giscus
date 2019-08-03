<?php

namespace App\Jobs;

use Carbon\Carbon;
use App\Mail\NewComment;
use App\NotifiedComment;
use App\GitHubMarkdownParser;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Concerns\IdentifiesIfACommentNeedsNotification;

class NotifyUserOfNewGistComment extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels, IdentifiesIfACommentNeedsNotification;

    private $user;

    private $comment;

    private $gist;

    public function __construct($user, $comment, $gist)
    {
        $this->user = $user;
        $this->comment = $comment;
        $this->gist = $gist;
    }

    public function handle()
    {
        if (! $this->commentNeedsNotification($this->comment, $this->user)) {
            Log::info(sprintf(
                'Skipped emailing notification for comment %s because it no longer needs notification.',
                $this->comment['id']
            ));

            return true;
        }

        $this->sendNotificationEmail($this->comment, $this->gist, $this->user);

        $this->markCommentAsNotified($this->comment);

        Log::info('Emailed notification for comment '.$this->comment['id']);
    }

    private function sendNotificationEmail($comment, $gist, $user)
    {
        $parser = app()->make(GitHubMarkdownParser::class);
        $parser->authenticateFor($user);

        Mail::to($user)->send(
            new NewComment($comment, $gist, $parser->parse($comment['body']), $user)
        );
    }

    private function markCommentAsNotified($comment)
    {
        $eloquentComment = NotifiedComment::firstOrNew([
            'github_id' => $comment['id'],
        ]);

        $eloquentComment->github_updated_at = Carbon::createFromFormat('Y-m-d\TH:i:s\Z', $comment['updated_at']);

        $eloquentComment->save();
    }
}
