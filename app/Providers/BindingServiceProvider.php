<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\SendMail\SendMailServiceInterface;
use App\Services\SendMail\SendMailService;

class BindingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(SendMailServiceInterface::class, SendMailService::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
