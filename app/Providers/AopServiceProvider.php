<?php

namespace App\Providers;

use Doctrine\Common\Annotations\Reader;
use Go\Core\AspectContainer;
use Illuminate\Contracts\Foundation\Application;
use App\Aspect\LoggingAspect;
use Illuminate\Support\ServiceProvider;
use PhpDeal\Aspect\InvariantCheckerAspect;
use PhpDeal\Aspect\PostconditionCheckerAspect;
use PhpDeal\Aspect\PreconditionCheckerAspect;
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
            return new LoggingAspect($app->make(LoggerInterface::class));
        });
        
        $this->app->singleton(Reader::class, function (Application $app) {
            $container = $app->make(AspectContainer::class);

            return $container->get('aspect.annotation.reader');
        });
        $this->app->singleton(InvariantCheckerAspect::class, function (Application $app) {
            return new InvariantCheckerAspect($app->make(Reader::class));
        });
        $this->app->singleton(PreconditionCheckerAspect::class, function (Application $app) {
            return new PreconditionCheckerAspect($app->make(Reader::class));
        });
        $this->app->singleton(PostconditionCheckerAspect::class, function (Application $app) {
            return new PostconditionCheckerAspect($app->make(Reader::class));
        });

        $this->app->tag(
            [
                LoggingAspect::class,
                InvariantCheckerAspect::class,
                PreconditionCheckerAspect::class,
                PostconditionCheckerAspect::class
            ],
            'goaop.aspect'
        );
    }
}
