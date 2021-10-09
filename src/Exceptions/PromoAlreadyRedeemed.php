<?php

namespace OguzcanDemircan\LaravelPromo\Exceptions;

use OguzcanDemircan\LaravelPromo\Models\Promo;

class PromoAlreadyRedeemed extends \Exception
{
    protected $message = 'The Promo was already redeemed.';

    protected $Promo;

    public static function create(Promo $Promo)
    {
        return new static($Promo);
    }

    public function __construct(Promo $Promo)
    {
        $this->Promo = $Promo;
    }
}
