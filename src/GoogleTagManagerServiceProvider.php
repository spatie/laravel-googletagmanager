<?php

namespace Spatie\GoogleTagManager;

use Config;
use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Application;

class GoogleTagManagerServiceProvider extends ServiceProvider {

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->version === 4) {

        } else {
            $this->loadViewsFrom(__DIR__.'/../views', 'googletagmanager');

            $this->publishes([
                __DIR__.'/../config/googletagmanager.php' => config_path('googletagmanager.php'),
            ]);
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->version = intval(Application::VERSION);

        if ($this->version === 4) {
            $this->package('spatie/googletagmanager', null, __DIR__.'/..');

            $id = Config::get('googletagmanager::id');
            $enabled = Config::get('googletagmanager::enabled');
        } else {
            $this->mergeConfigFrom(__DIR__.'/../config/googletagmanager.php', 'googletagmanager');

            $id = Config::get('googletagmanager.id');
            $enabled = Config::get('googletagmanager.enabled');
        }

        $googleTagManager = new GoogleTagManager($id);

        if ($enabled === false) {
            $googleTagManager->disable();
        }

        $this->app->instance('Spatie\GoogleTagManager\GoogleTagManager', $googleTagManager);
        $this->app->alias('Spatie\GoogleTagManager\GoogleTagManager', 'googletagmanager');

        $this->app['view']->creator(
            ['googletagmanager::script', 'googletagmanager::push'],
            'Spatie\GoogleTagManager\ScriptViewCreator'
        );
    }
}
