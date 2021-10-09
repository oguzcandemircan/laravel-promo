<?php

namespace OguzcanDemircan\LaravelPromo\Traits;

use OguzcanDemircan\LaravelPromo\Models\Promo;
use OguzcanDemircan\LaravelPromo\Facades\LaravelPromo;

trait HasPromo
{
    /**
     * Set the polymorphic relation.
     *
     * @return mixed
     */
    public function Promo()
    {
        return $this->morphMany(config('Promo.model', Promo::class), 'model');
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
    public function createPromo(array $data = [], $expires_at = null)
    {
        return $this->createPromo(1, $data, $expires_at)[0];
    }
}
