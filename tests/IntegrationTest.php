<?php

namespace Tests;

use Illuminate\Support\Str;
use Orchestra\Testbench\TestCase as BaseTest;
use Illuminate\Database\Eloquent\Factories\Factory;

abstract class IntegrationTest extends BaseTest
{
    /**
     * Setup the test environment
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->loadMigrationsFrom(DOC_ROOT.'database/migrations');
        $this->setFactoryLocation();
        $this->bindDependencies();
    }

    protected function setFactoryLocation()
    {
        Factory::guessFactoryNamesUsing(function($modelName) {
            $factoryName = 'Database\\Factories\\'.Str::after($modelName, '\\Models\\').'Factory';
            return $factoryName;
        });
    }

    protected function getPackageProviders($app)
    {
        return [
            'Dmlogic\RecruitmentApi\RecruitmentApiProvider',
        ];
    }

    /**
     * Define environment setup.
     *
     * @param \Illuminate\Foundation\Application $app
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('app.faker_locale', 'en_GB');
        $app['config']->set('recruitment.endpoint', 'api');

        // // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
    }
}
