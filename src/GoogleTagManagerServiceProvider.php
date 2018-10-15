<?php

namespace Spatie\GoogleTagManager;

use Illuminate\Support\ServiceProvider;
use Spatie\GoogleTagManager\GoogleTagManager;

class GoogleTagManagerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'googletagmanager');

        $this->publishes([
            __DIR__.'/../resources/config/config.php' => config_path('googletagmanager.php'),
        ], 'config');

        $this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/googletagmanager'),
        ], 'views');

        $this->app['view']->creator(
            ['googletagmanager::head', 'googletagmanager::body', 'googletagmanager::script'],
            'Spatie\GoogleTagManager\ScriptViewCreator'
        );
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../resources/config/config.php', 'googletagmanager');

        $googleTagManager = new GoogleTagManager(config('googletagmanager.id'));

        if (config('googletagmanager.enabled') === false) {
            $googleTagManager->disable();
        }

        $this->app->instance('Spatie\GoogleTagManager\GoogleTagManager', $googleTagManager);
        $this->app->alias('Spatie\GoogleTagManager\GoogleTagManager', 'googletagmanager');

        if (is_file(config('googletagmanager.macroPath'))) {
            include config('googletagmanager.macroPath');
        }
    }
}
