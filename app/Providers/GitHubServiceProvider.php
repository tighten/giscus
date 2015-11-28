<?php

namespace App\Providers;

use Github\Client as GithubClient;
use Github\HttpClient\CachedHttpClient;
use Illuminate\Support\ServiceProvider;

class GitHubServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('Github\Client', function ($app) {
            $githubClient = new GithubClient(
                new CachedHttpClient([
                    'cache_dir' => '/tmp/github-api-cache'
                ])
            );

            if (config('services.github.client_id') && config('services.github.client_secret')) {
                $githubClient->authenticate(
                    config('services.github.client_id'),
                    config('services.github.client_secret'),
                    GithubClient::AUTH_URL_CLIENT_ID
                );
            }

            return $githubClient;
        });
    }
}
