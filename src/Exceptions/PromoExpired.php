<?php

namespace OguzcanDemircan\LaravelPromo\Exceptions;

use OguzcanDemircan\LaravelPromo\Models\Promo;

class PromoExpired extends \Exception
{
    protected $message = 'The promo is already expired.';

    protected $promo;

    public static function create(Promo $promo)
    {
        return new static($promo);
    }

    public function __construct(Promo $promo)
    {
        $this->promo = $promo;
    }
}
