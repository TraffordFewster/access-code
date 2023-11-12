<?php

namespace Traffordfewster\AccessCode\Tests;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Orchestra\Testbench\TestCase as TestbenchTestCase;
use Traffordfewster\AccessCode\AccessCodeServiceProvider;

class TestCase extends TestbenchTestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->setUpDatabase($this->app);
    }

    protected function defineEnvironment($app)
    {
        $app['config']->set('database.default', 'testing');

        parent::defineEnvironment($app);
    }

    protected function getPackageProviders($app)
    {
        $serviceProviders = [
            AccessCodeServiceProvider::class,
        ];

        return $serviceProviders;
    }

    protected function setUpDatabase($app)
    {
        $app['db']->connection()->getSchemaBuilder()->create('test_models', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
        });
    }
}