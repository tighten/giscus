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
            return in_array($user->email, explode(',', config('horizon.users')));
        });
    }

    public function register()
    {
        //
    }
}
