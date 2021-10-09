<?php

namespace OguzcanDemircan\LaravelPromo\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use OguzcanDemircan\LaravelPromo\LaravelPromoServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    public function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'OguzcanDemircan\\LaravelPromo\\Database\\Factories\\' . class_basename($modelName) . 'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            LaravelPromoServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        /*
        include_once __DIR__.'/../database/migrations/create_laravel-promo_table.php.stub';
        (new \CreatePackageTable())->up();
        */
    }
}
