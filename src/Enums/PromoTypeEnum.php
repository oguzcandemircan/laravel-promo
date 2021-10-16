<?php

namespace OguzcanDemircan\LaravelPromo\Enums;

use Spatie\Enum\Enum;

/**
 * @method static self coupon()
 * @method static self inBasket()
 * @method static self inProductDetail()
 */
final class PromoTypeEnum extends Enum
{
    protected static function labels(): array
    {
        return [
            'coupon' => '<span class="badge badge-pill badge-primary">Kupon Kodu</span>',
            'inBasket' => '<span class="badge badge-pill badge-success">Sepette</span>',
            'inProductDetail' => '<span class="badge badge-pill badge-info">Ürün Detayında</span>',
        ];
    }
}
