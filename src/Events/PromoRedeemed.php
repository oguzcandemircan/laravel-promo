<?php

namespace OguzcanDemircan\LaravelPromo\Events;

use Illuminate\Queue\SerializesModels;
use OguzcanDemircan\LaravelPromo\Models\Promo;

class PromoRedeemed
{
    use SerializesModels;

    public $user;

    /** @var Promo */
    public $promo;

    public function __construct($user, Promo $promo)
    {
        $this->user = $user;
        $this->Promo = $promo;
    }
}
