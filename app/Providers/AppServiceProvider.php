<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Response\ResponseManager;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('response', function ($app) {
            return new ResponseManager;
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
