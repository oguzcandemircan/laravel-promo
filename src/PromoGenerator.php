<?php

namespace OguzcanDemircan\LaravelPromo;

use Illuminate\Database\Eloquent\Model;
use OguzcanDemircan\LaravelPromo\Facades\LaravelPromo;

class PromoGenerator
{
    public $code;

    public $start_at;

    public $expire_at;

    public $conditions;

    public $rewards;

    public $data = [];

    public $type;

    public $is_active;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function code($code = null)
    {
        $this->code = $code;

        return $this;
    }

    public function expire($date = null)
    {
        $this->expire_at = $date;

        return $this;
    }

    public function conditions($conditions = [])
    {
        $this->conditions = $conditions;

        return $this;
    }

    public function rewards($rewards = [])
    {
        $this->rewards = $rewards;

        return $this;
    }

    public function generate()
    {
        LaravelPromo::create(
            1,
            $this->rewards,
            $this->conditions,
            $this->data,
            $this->expire_at,
            $this->start_at,
        );
    }
}
