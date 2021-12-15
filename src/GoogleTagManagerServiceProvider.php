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

        $this->app->singleton(GoogleTagManager::class, function($app) {
            $googleTagManager = new GoogleTagManager(config('googletagmanager.id'));
            
            if (config('googletagmanager.enabled') === false) {
                $googleTagManager->disable();
            }
            
            return $googleTagManager;
        });
        $this->app->alias(GoogleTagManager::class, 'googletagmanager');

        if (is_file(config('googletagmanager.macroPath'))) {
            include config('googletagmanager.macroPath');
        }
    }
}
