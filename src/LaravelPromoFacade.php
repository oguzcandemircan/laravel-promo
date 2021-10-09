<?php

namespace OguzcanDemircan\LaravelPromo;

use Illuminate\Support\Facades\Facade;

/**
 * @see \OguzcanDemircan\LaravelPromo\LaravelPromo
 */
class LaravelPromoFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return LaravelPromo::class;
    }
}
