<?php

namespace App\Providers;

use Laravel\Horizon\Horizon;
use Illuminate\Support\Facades\Gate;
use Laravel\Horizon\HorizonApplicationServiceProvider;

class HorizonServiceProvider extends HorizonApplicationServiceProvider
{
    public function boot()
    {
        parent::boot();

        Horizon::routeSlackNotificationsTo(config('services.slack.horizon_webhook_url'), '#os-giscus');
    }

    protected function gate()
    {
        Gate::define('viewHorizon', function ($user) {
            return ends_with($user->email, '@tighten.co') ||
                in_array($user->email, [
                    'anthonygterrell@gmail.com',
                    'logan@loganhenson.com',
                ]);
        });
    }

    public function register()
    {
        //
    }
}
