<?php

namespace OguzcanDemircan\LaravelPromo;

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
            ->hasMigration('create_laravel-promo_table')
            ->hasCommand(LaravelPromoCommand::class);
    }
}
