<?php

namespace App\Jobs;

use Github\Client;
use Github\HttpClient\CachedHttpClient;

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

        // Can we get only those updated since date? the APi can.. can our client? and does a new comment make it marked as updated?
        foreach ($this->client->api('gists')->all() as $gist) {
            foreach ($this->client->api('gist')->comments()->all($gist['id']) as $comment) {
                $this->handleComment($comment, $gist);
            }
        }

        $job->delete();
    }

    private function handleComment($comment, $gist)
    {
        // @todo: Has comment been notified? If not, notify and save; if so, skip
        dd($comment);
    }
}
