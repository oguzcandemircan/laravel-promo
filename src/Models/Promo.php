<?php

namespace OguzcanDemircan\LaravelPromo\Models;

use Illuminate\Database\Eloquent\Model;
use OguzcanDemircan\LaravelPromo\Traits\HasActive;

class Promo extends Model
{
    use HasActive;


    protected $guarded = [];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'expires_at',
        'starts_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'data' => 'collection',
        'conditions' => 'collection',
        'rewards' => 'collection',
        'expires_at' => 'datetime',
        'starts_at' => 'datetime',
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
        return $this->expires_at ? $this->expires_at->isPast() : false;
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

    public function isStart()
    {
        return $this->starts_at ? $this->starts_at->isFuture() : false;
    }

    public static function findByCode(string $code)
    {
        return self::where('code', $code)->first();
    }
}
