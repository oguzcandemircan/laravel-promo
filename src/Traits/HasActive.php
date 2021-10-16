<?php

namespace OguzcanDemircan\LaravelPromo\Traits;

use OguzcanDemircan\LaravelPromo\Enums\ActiveEnum;

/**
 *
 */
trait HasActive
{
    public function getStatusLabel()
    {
        return ActiveEnum::from($this->is_active)->label;
    }

    public function getStatusValue()
    {
        return ActiveEnum::from($this->is_active);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', ActiveEnum::active());
    }

    public function isActive()
    {
        return $this->status == ActiveEnum::active();
    }
}
