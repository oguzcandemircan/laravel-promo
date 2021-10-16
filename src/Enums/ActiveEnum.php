<?php

namespace OguzcanDemircan\LaravelPromo\Enums;

use Spatie\Enum\Enum;

/**
 * @method static self active()
 * @method static self passive()
 */
final class ActiveEnum extends Enum
{
    protected static function labels(): array
    {
        return [
            'passive' => '<span class="badge badge-pill badge-secondary">Pasif</span>',
            'active' => '<span class="badge badge-pill badge-success">Aktif</span>',
        ];
    }

    protected static function values(): array
    {
        return [
            'passive' => 0,
            'active' => 1,
        ];
    }
}
