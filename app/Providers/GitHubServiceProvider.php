<?php

namespace App\Providers;

use League\Flysystem\Filesystem;
use Github\Client as GithubClient;
use League\Flysystem\Adapter\Local;
use Illuminate\Support\ServiceProvider;
use Cache\Adapter\Filesystem\FilesystemCachePool;

class GitHubServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('psr-6-file-cache', function ($app) {
            $filesystemAdapter = new Local(sys_get_temp_dir().'/github-api-cache');
            $filesystem = new Filesystem($filesystemAdapter);

            return new FilesystemCachePool($filesystem);
        });

        $this->app->singleton(GithubClient::class, function ($app) {
            $githubClient = new GithubClient;
            $githubClient->addCache($app['psr-6-file-cache']);

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
