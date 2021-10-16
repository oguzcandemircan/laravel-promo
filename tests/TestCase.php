<?php

namespace OguzcanDemircan\LaravelPromo\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Testing\RefreshDatabase;
use OguzcanDemircan\LaravelPromo\LaravelPromoServiceProvider;
use OguzcanDemircan\LaravelPromo\Tests\Models\User;

class TestCase extends \Orchestra\Testbench\TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'OguzcanDemircan\\LaravelPromo\\Database\\Factories\\' . class_basename($modelName) . 'Factory'
        );

        $this->refreshDatabase();

        $this->setUpUser($this->app);
    }

    protected function getPackageProviders($app)
    {
        return [
            LaravelPromoServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        $this
            ->setUpDatabase($app);
    }

    protected function setUpDatabase($app): self
    {
        config()->set('database.default', 'sqlite');
        config()->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        $class = include __DIR__ . '/../database/migrations/create_promo_table.php.stub';
        $class->up();

        return $this;
    }

    public function setUpUser($app)
    {
        $app['config']->set('promo.user_model', \OguzcanDemircan\LaravelPromo\Tests\Models\User::class);

        $app['db']->connection()->getSchemaBuilder()->create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->timestamps();
        });

        User::query()->forceCreate([
            'name' => 'jhon doe',
            'email' => 'jhon@gmail.com',
        ]);
    }
}
