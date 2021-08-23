<?php

namespace Tests;

use Github\Client as GitHubClient;

class GitHubClientTest extends BrowserKitTestCase
{
    /** @test */
    public function itAuthenticatesWithGithubAndReturns5000RateLimitGuzzle()
    {
        if (! config('services.github.client_id') || ! config('services.github.client_secret')) {
            $this->markTestSkipped('Missing GitHub credentials.');
        }

        $github = $this->app->make(GitHubClient::class);
        $response = $github->getHttpClient()->get('rate_limit');
        $limit = $response->getHeader('X-RateLimit-Limit')[0];
        $this->assertEquals(5000, $limit);
    }
}
