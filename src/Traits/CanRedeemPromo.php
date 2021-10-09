<?php

namespace OguzcanDemircan\LaravelPromo\Traits;

use OguzcanDemircan\LaravelPromo\Events\PromoRedeemed;
use OguzcanDemircan\LaravelPromo\Exceptions\PromoAlreadyRedeemed;
use OguzcanDemircan\LaravelPromo\Exceptions\PromoExpired;
use OguzcanDemircan\LaravelPromo\Exceptions\PromoIsInvalid;
use OguzcanDemircan\LaravelPromo\Facades\LaravelPromo;
use OguzcanDemircan\LaravelPromo\Models\Promo;

trait CanRedeemPromo
{
    /**
     * @param string $code
     * @throws PromoExpired
     * @throws PromoIsInvalid
     * @throws PromoAlreadyRedeemed
     * @return mixed
     */
    public function redeemCode(string $code)
    {
        $promo = LaravelPromo::check($code);

        if ($promo->users()->wherePivot('user_id', $this->id)->exists()) {
            throw PromoAlreadyRedeemed::create($promo);
        }
        if ($promo->isExpired()) {
            throw PromoExpired::create($promo);
        }

        $this->promos()->attach($promo, [
            'redeemed_at' => now(),
        ]);

        event(new PromoRedeemed($this, $promo));

        return $promo;
    }

    /**
     * @param Promo $promo
     * @throws PromoExpired
     * @throws PromoIsInvalid
     * @throws PromoAlreadyRedeemed
     * @return mixed
     */
    public function redeemPromo(Promo $promo)
    {
        return $this->redeemCode($promo->code);
    }

    /**
     * @return mixed
     */
    public function promos()
    {
        return $this->belongsToMany(config('promo.model'), config('promo.relation_table'))->withPivot('redeemed_at');
    }
}
