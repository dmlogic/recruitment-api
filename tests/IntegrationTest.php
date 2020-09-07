<?php

namespace Tests;

use Orchestra\Testbench\TestCase as BaseTest;

abstract class IntegrationTest extends BaseTest
{
    /**
     * Setup the test environment
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->loadMigrationsFrom(DOC_ROOT.'database/migrations');
        // $this->withFactories(DOC_ROOT.'tests/database/factories');
        $this->bindDependencies();
        // app()->make('Seeds\GroupsSeeder')->run();
        // app()->make('Seeds\UserUploadSeeder')->run();
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

        // // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
    }

    protected function bindDependencies()
    {
    }
}
