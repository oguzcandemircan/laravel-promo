<?php

namespace OguzcanDemircan\LaravelPromo\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'model_id',
        'model_type',
        'code',
        'data',
        'expires_at'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'expires_at'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'data' => 'collection'
    ];

    /**
     * Get the users who redeemed this Promo.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(config('promo.user_model'), config('promo.relation_table'))->withPivot('redeemed_at');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function model()
    {
        return $this->morphTo();
    }

    /**
     * Check if code is expired.
     *
     * @return bool
     */
    public function isExpired()
    {
        return $this->expires_at ? Carbon::now()->gte($this->expires_at) : false;
    }

    /**
     * Check if code is not expired.
     *
     * @return bool
     */
    public function isNotExpired()
    {
        return !$this->isExpired();
    }
}
