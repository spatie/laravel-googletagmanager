<?php

namespace Spatie\GoogleTagManager\Providers;

use Illuminate\Support\ServiceProvider;

class Laravel5 extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/views', 'googletagmanager');

        $this->publishes([
            __DIR__.'/config/googletagmanager.php' => config_path('googletagmanager.php'),
        ]);

        $this->app['view']->creator(
            ['googletagmanager::script', 'googletagmanager::push'],
            'Spatie\GoogleTagManager\ScriptViewCreator'
        );
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/config/googletagmanager.php', 'googletagmanager');

        $googleTagManager = new GoogleTagManager(Config::get('googletagmanager.id'));

        if (Config::get('googletagmanager.enabled') === false) {
            $googleTagManager->disable();
        }

        $this->app->instance('Spatie\GoogleTagManager\GoogleTagManager', $googleTagManager);
        $this->app->alias('Spatie\GoogleTagManager\GoogleTagManager', 'googletagmanager');
    }
}
