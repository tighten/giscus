<?php

namespace App\Jobs;

use App\NotifiedComment;
use Github\Client;
use Github\HttpClient\CachedHttpClient;
use Illuminate\Support\Facades\Queue;

class NotifyUserOfNewGistComments extends Job
{
    private $client;

    public function __construct()
    {
        // @todo: Bind and inject
        $this->client = new Client(
            new CachedHttpClient(['cache_dir' => '/tmp/github-api-cache'])
        );
    }

    public function fire($job, $data)
    {
        $this->client->authenticate($data['user']->token, Client::AUTH_HTTP_TOKEN);

        // Can we get only those updated since date? the API can.. can our client? and does a new comment make it marked as updated?
        foreach ($this->client->api('gists')->all() as $gist) {
            foreach ($this->client->api('gist')->comments()->all($gist['id']) as $comment) {
                $this->handleComment($comment, $gist, $data['user']);
            }
        }

        $job->delete();
    }

    private function handleComment($comment, $gist, $user)
    {
        if ($this->commentNeedsNotification($comment)) {
            $this->notifyComment($comment, $gist, $user);
        }
    }

    private function commentNeedsNotification($comment)
    {
        return NotifiedComment::where('github_id', $comment['id'])
            ->where('github_updated_at', $comment['updated_at'])
            ->count() == 0;
    }

    private function notifyComment($comment, $gist, $user)
    {
        Queue::push(NotifyUserOfNewGistComment::class, [
            'user' => $user,
            'comment' => $comment,
            'gist' => $gist
        ]);
    }
}
