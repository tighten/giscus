<?php namespace App;

use Github\Client;
use Github\ResultPager;

class GistClient
{
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function all($user)
    {
        return $this->pagedAuthenticatedCall('gists', 'all', $user);
    }

    private function pagedAuthenticatedCall($api, $method, $user, $parameters = [])
    {
        $this->client->authenticate($user->token, Client::AUTH_HTTP_TOKEN);
        $api = $this->client->api($api);

        $paginator = new ResultPager($this->client);
        $parameters = array_merge(['github'], $parameters); // wut?
        $result = $paginator->fetchAll($api, $method, $parameters);

        // @todo: Can we un-authenticate now?

        return $result;
    }
}
