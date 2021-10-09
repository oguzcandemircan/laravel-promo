<?php

namespace OguzcanDemircan\LaravelPromo;

use OguzcanDemircan\Promocodes\PromoCodeGenerator;
use OguzcanDemircan\LaravelPromo\Commands\LaravelPromoCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelPromoServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-promo')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_promo_table')
            ->hasCommand(LaravelPromoCommand::class);
    }

    public function registeringPackage()
    {
        $this->app->singleton('LaravelPromo', function ($app) {
            $generator = new PromoCodeGenerator(config('promo.characters'), config('promo.mask'));
            $generator->setPrefix(config('promo.prefix'));
            $generator->setSuffix(config('promo.suffix'));
            $generator->setSeparator(config('promo.separator'));
            return new LaravelPromo($generator);
        });
    }
}
