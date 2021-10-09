<?php

namespace OguzcanDemircan\LaravelPromo\Traits;

use OguzcanDemircan\LaravelPromo\Facades\LaravelPromo;
use OguzcanDemircan\LaravelPromo\Models\Promo;

trait HasPromo
{
    /**
     * Set the polymorphic relation.
     *
     * @return mixed
     */
    public function promo()
    {
        return $this->morphMany(config('promo.model', Promo::class), 'model');
    }

    /**
     * @param int $amount
     * @param array $data
     * @param null $expires_at
     * @return Promo[]
     */
    public function createPromo(int $amount, array $data = [], $expires_at = null)
    {
        return LaravelPromo::create($this, $amount, $data, $expires_at);
    }

    /**
     * @param array $data
     * @param null $expires_at
     * @return Promo
     */
    public function createPromos(array $data = [], $expires_at = null)
    {
        return $this->createPromo(1, $data, $expires_at)[0];
    }
}
