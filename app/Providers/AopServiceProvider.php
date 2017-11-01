<?php

namespace App\Providers;

//use Illuminate\Support\ServiceProvider;

use App\Aspect\LoggingAspect;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Psr\Log\LoggerInterface;

class AopServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(LoggingAspect::class, function (Application $app) {
            return new LoggingAspect($app->make(LoggerInterface::class)); //We still need to connect the class to the provider
        });

        $this->app->tag([LoggingAspect::class], 'goaop.aspect');
    }
}
