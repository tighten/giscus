<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class GitHubServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('Github\Client', function ($app) {
            return new \Github\Client(
                new \Github\HttpClient\CachedHttpClient([
                    'cache_dir' => '/tmp/github-api-cache'
                ])
            );
        });
    }
}
