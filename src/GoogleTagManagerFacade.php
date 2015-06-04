<?php

namespace Spatie\GoogleTagManager;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Spatie\GoogleTagManager\GoogleTagManager
 */
class GoogleTagManagerFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'googletagmanager';
    }
}
