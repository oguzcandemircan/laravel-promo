<?php

namespace OguzcanDemircan\LaravelPromo\Tests;

use Illuminate\Support\Facades\Event;
use OguzcanDemircan\LaravelPromo\Events\PromoRedeemed;
use OguzcanDemircan\LaravelPromo\Exceptions\PromoAlreadyRedeemed;
use OguzcanDemircan\LaravelPromo\Exceptions\PromoExpired;
use OguzcanDemircan\LaravelPromo\Exceptions\PromoIsInvalid;
use OguzcanDemircan\LaravelPromo\Facades\LaravelPromo;
use OguzcanDemircan\LaravelPromo\Tests\Models\User;

class CanRedeemPromoTest extends TestCase
{
    /** @test */
    public function users_can_generate_promo()
    {
        $promo = LaravelPromo::make()
            ->conditions(['key' => 'value'])
            ->rewards(['key' => 'value'])
            ->expire(now()->addMonth(1))
            ->generate();
    }

    /** @test */
    public function it_throws_an_invalid_promo_exception_for_invalid_codes()
    {
        $this->expectException(PromoIsInvalid::class);

        $user = User::first();

        $user->redeemCode('invalid');
    }

    /** @test */
    public function it_attaches_users_when_they_redeem_a_code()
    {
        $user = User::find(1);

        $promos = LaravelPromo::create(1);
        $promo = $promos[0];

        $user->redeemCode($promo->code);

        $this->assertCount(1, $user->promos);

        $userLaravelPromo = $user->promos()->first();
        $this->assertNotNull($userLaravelPromo->pivot->redeemed_at);
    }

    /** @test */
    public function users_can_not_redeem_the_same_promo_twice()
    {
        $this->expectException(PromoAlreadyRedeemed::class);

        $user = User::find(1);

        $promos = LaravelPromo::create(1);
        $promo = $promos[0];

        $user->redeemCode($promo->code);
        $user->redeemCode($promo->code);
    }

    /** @test */
    public function users_can_not_redeem_expired_promos()
    {
        $this->expectException(PromoExpired::class);

        $user = User::find(1);

        $promos = LaravelPromo::create(1, [], [], [], today()->subDay());

        $promo = $promos[0];

        $user->redeemCode($promo->code);
    }

    /** @test */
    public function users_can_redeem_promo()
    {
        $this->expectException(PromoAlreadyRedeemed::class);

        $user = User::find(1);

        $promos = LaravelPromo::create(1);
        $promo = $promos[0];

        $user->redeemPromo($promo);
        $user->redeemPromo($promo);
    }

    /** @test */
    public function redeeming_promos_fires_an_event()
    {
        Event::fake();

        $user = User::find(1);

        $promos = LaravelPromo::create(1);
        $promo = $promos[0];

        $user->redeemPromo($promo);

        Event::assertDispatched(PromoRedeemed::class, function ($e) use ($user, $promo) {
            return $e->user->id === $user->id && $e->promo->id === $promo->id;
        });
    }
}
