<?php

namespace Spatie\GoogleTagManager\Providers;

use Illuminate\Support\ServiceProvider;
use Spatie\GoogleTagManager\GoogleTagManager;

class Laravel4 extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->package('spatie/googletagmanager', null, __DIR__.'/../../resources');

        $this->app['view']->creator(
            ['googletagmanager::script', 'googletagmanager::push'],
            'Spatie\GoogleTagManager\ScriptViewCreator'
        );
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->app['googletagmanager'] = $this->app->share(function ($app) {
            $googleTagManager = new GoogleTagManager($app['config']->get('googletagmanager::id'));

            if ($app['config']->get('googletagmanager::enabled') === false) {
                $googleTagManager->disable();
            }

            return $googleTagManager;
        });

        $this->app->bind('Spatie\GoogleTagManager\GoogleTagManager', 'googletagmanager');
    }

    public function provides()
    {
        return ['googletagmanager'];
    }
}
