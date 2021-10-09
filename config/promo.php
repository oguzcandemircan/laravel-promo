<?php

use OguzcanDemircan\LaravelPromo\Models\Promo;

return [

    /*
     * Database table name that will be used in migration
     */
    'table' => 'promos',

    /*
     * Model to use
     */
    'model' => Promo::class,

    /*
     * Database pivot table name for promos and users relation
     */
    'relation_table' => 'user_promo',

    /*
     * List of characters that will be used for promo code generation.
     */
    'characters' => '23456789ABCDEFGHJKLMNPQRSTUVWXYZ',

    /*
     * Promo code prefix.
     *
     * Example: foo
     * Generated Code: foo-AGXF-1NH8
     */
    'prefix' => null,

    /*
     * Promo code suffix.
     *
     * Example: foo
     * Generated Code: AGXF-1NH8-foo
     */
    'suffix' => null,

    /*
     * Code mask.
     * All asterisks will be removed by random characters.
     */
    'mask' => '****-****',

    /*
     * Separator to be used between prefix, code and suffix.
     */
    'separator' => '-',

    /*
     * The user model that belongs to promos.
     */
    'user_model' => \App\User::class,
];
