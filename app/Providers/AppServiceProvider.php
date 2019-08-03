<?php

namespace App\Providers;

use Psr\Log\LoggerInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->alias('bugsnag.multi', Log::class);
        $this->app->alias('bugsnag.multi', LoggerInterface::class);
    }
}
