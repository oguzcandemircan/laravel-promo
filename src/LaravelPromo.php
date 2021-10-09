<?php

namespace OguzcanDemircan\LaravelPromo;

use Illuminate\Database\Eloquent\Model;
use OguzcanDemircan\LaravelPromo\Exceptions\PromoExpired;
use OguzcanDemircan\LaravelPromo\Exceptions\PromoIsInvalid;
use OguzcanDemircan\LaravelPromo\Models\Promo;

class LaravelPromo
{
    /** @var PromoCodeGenerator */
    private $generator;
    /** @var \OguzcanDemircan\promoCodes\Models\promoCode */
    private $promoCodeModel;

    public function __construct(PromoCodeGenerator $generator)
    {
        $this->generator = $generator;
        $this->promoCodeModel = app(config('promo.model', Promo::class));
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
    public function create(Model $model, int $amount = 1, array $data = [], $expires_at = null)
    {
        $promoCodes = [];

        foreach ($this->generate($amount) as $promoCodeCode) {
            $promoCodes[] = $this->promoCodeModel->create([
                'model_id' => $model->getKey(),
                'model_type' => $model->getMorphClass(),
                'code' => $promoCodeCode,
                'data' => $data,
                'expires_at' => $expires_at,
            ]);
        }

        return $promoCodes;
    }

    /**
     * @param string $code
     * @throws PromoIsInvalid
     * @throws PromoExpired
     * @return Promo
     */
    public function check(string $code)
    {
        $promoCode = $this->promoCodeModel->whereCode($code)->first();

        if (is_null($promoCode)) {
            throw PromoIsInvalid::withCode($code);
        }
        if ($promoCode->isExpired()) {
            throw PromoExpired::create($promoCode);
        }

        return $promoCode;
    }

    /**
     * @return string
     */
    protected function getUniquepromoCode(): string
    {
        $promoCode = $this->generator->generateUnique();

        while ($this->promoCodeModel->whereCode($promoCode)->count() > 0) {
            $promoCode = $this->generator->generateUnique();
        }

        return $promoCode;
    }
}
