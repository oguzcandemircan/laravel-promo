<?php

namespace OguzcanDemircan\LaravelPromo\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @mixin \OguzcanDemircan\LaravelPromo\Promo
 */
class LaravelPromo extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravel-promo';
    }
}
