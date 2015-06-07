<?php

namespace Spatie\GoogleTagManager;

use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Spatie\GoogleTagManager\Providers\Laravel4;
use Spatie\GoogleTagManager\Providers\Laravel5;

class GoogleTagManagerServiceProvider extends ServiceProvider
{
    /**
     * @var \Illuminate\Support\ServiceProvider;
     */
    protected $provider;

    public function __construct($app)
    {
        parent::__construct($app);

        $version = intval(Application::VERSION);

        if ($version === 4) {
            $this->provider = new Laravel4($app);
        } else {
            $this->provider = new Laravel5($app);
        }
    }

    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->provider->boot();
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->provider->register();
    }
}
