<?php

namespace OguzcanDemircan\LaravelPromo\Tests\Models;

use OguzcanDemircan\LaravelPromo\Traits\CanRedeemPromo;

class User extends \Illuminate\Foundation\Auth\User
{
    use CanRedeemPromo;
}
