<?php

namespace OguzcanDemircan\LaravelPromo;

use Illuminate\Database\Eloquent\Model;
use OguzcanDemircan\LaravelPromo\Enums\ActiveEnum;
use OguzcanDemircan\LaravelPromo\Enums\PromoTypeEnum;
use OguzcanDemircan\LaravelPromo\Exceptions\PromoAlreadyRedeemed;
use OguzcanDemircan\LaravelPromo\Exceptions\PromoExpired;
use OguzcanDemircan\LaravelPromo\Exceptions\PromoIsInvalid;
use OguzcanDemircan\LaravelPromo\Models\Promo;

class LaravelPromo
{
    /** @var PromoCodeGenerator */
    private $generator;
    /** @var \OguzcanDemircan\LaravelPromo\Models\Promo */
    private $promoModel;

    public function __construct(PromoCodeGenerator $generator)
    {
        $this->generator = $generator;
        $this->promoModel = app(config('promo.model', Promo::class));
    }

    public function make()
    {
        return (new PromoGenerator($this->promoModel));
    }

    /**
     * Generate the specified amount of codes and return
     * an array with all the generated codes.
     *
     * @param int $amount
     * @return array
     */
    public function generate(int $amount = 1): array
    {
        $codes = [];

        for ($i = 1; $i <= $amount; $i++) {
            $codes[] = $this->getUniquepromoCode();
        }

        return $codes;
    }

    /**
     * @param Model $model
     * @param int $amount
     * @param array $data
     * @param null $expires_at
     * @return array
     */
    public function create(int $amount = 1, array $rewards = [], array $conditions = [], array $data = [], $expires_at = null, $starts_at = null)
    {
        $promoCodes = [];

        foreach ($this->generate($amount) as $code) {
            $promoCodes[] = $this->promoModel->create([
                'type' => PromoTypeEnum::coupon(),
                'is_active' => ActiveEnum::active(),
                'code' => $code,
                'rewards' => $rewards,
                'conditions' => $conditions,
                'data' => $data,
                'expires_at' => $expires_at,
                'starts_at' => $starts_at,
            ]);
        }

        return $promoCodes;
    }

    public function createWithCode(string $code, array $rewards = [], array $conditions = [], array $data = [], $expires_at = null, $starts_at = null)
    {
        $this->promoModel->create([
            'type' => PromoTypeEnum::coupon(),
            'is_active' => ActiveEnum::active(),
            'code' => $code,
            'rewards' => $rewards,
            'conditions' => $conditions,
            'data' => $data,
            'expires_at' => $expires_at,
            'starts_at' => $starts_at,
        ]);
    }

    /**
     * @param string $code
     * @throws PromoIsInvalid
     * @throws PromoExpired
     * @return Promo
     */
    public function check(string $code)
    {
        $promo = $this->promoModel->whereCode($code)->first();

        if (is_null($promo)) {
            throw PromoIsInvalid::withCode($code);
        }
        if ($promo->isExpired()) {
            throw PromoExpired::create($promo);
        }

        if (auth()->check() && $promo->users()->wherePivot('user_id', auth()->id())->exists()) {
            throw PromoAlreadyRedeemed::create($promo);
        }

        return $promo;
    }

    /**
     * @return string
     */
    protected function getUniquepromoCode(): string
    {
        $promoCode = $this->generator->generateUnique();

        while ($this->promoModel->whereCode($promoCode)->count() > 0) {
            $promoCode = $this->generator->generateUnique();
        }

        return $promoCode;
    }
}
