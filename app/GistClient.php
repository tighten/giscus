<?php

namespace App;

use Github\ResultPager;
use Github\Client as GitHubClient;

class GistClient
{
    private $client;

    public function __construct(GitHubClient $client)
    {
        $this->client = $client;
    }

    public function all($user)
    {
        return $this->pagedAuthenticatedCall('gists', 'all', $user);
    }

    private function pagedAuthenticatedCall($api, $method, $user, $parameters = [])
    {
        $this->client->authenticate($user->token, GitHubClient::AUTH_HTTP_TOKEN);
        $api = $this->client->api($api);

        $paginator = new ResultPager($this->client);
        $parameters = array_merge(['github'], $parameters);

        return $paginator->fetchAll($api, $method, $parameters);
    }
}
