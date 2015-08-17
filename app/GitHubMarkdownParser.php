<?php

namespace App;

use Github\Client;
use Github\HttpClient\Message\ResponseMediator;

class GitHubMarkdownParser
{
    private $client;

    public function __construct($user, Client $client)
    {
        $this->client = $client;
        $this->client->authenticate($user->token, Client::AUTH_HTTP_TOKEN);
    }

    public function parse($markdown)
    {
        $body = json_encode([
            'text' => $markdown
        ]);

        $response = $this->client->getHttpClient()->post('markdown', $body);

        return ResponseMediator::getContent($response);
    }
}
