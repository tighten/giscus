<?php

namespace App;

use Exception;
use Github\Client;
use Github\HttpClient\Message\ResponseMediator;

class GitHubMarkdownParser
{
    private $client;
    private $authenticated = false;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * This hideous setter is brought to you by Laravel 5.4+ no longer making
     * it possible to both A) require variable input in the constructor and
     * B) mock that class later.
     */
    public function authenticateFor($user)
    {
        $client->authenticate($user->token, Client::AUTH_HTTP_TOKEN);
        $this->authenticated = true;
    }

    public function parse($markdown)
    {
        if (! $this->authenticated) {
            throw new Exception("Cannot use the GitHub Markdown Parser without authenticating a user.");
        }

        $body = json_encode([
            'text' => $markdown
        ]);

        $response = $this->client->getHttpClient()->post('markdown', $body);

        return ResponseMediator::getContent($response);
    }
}
