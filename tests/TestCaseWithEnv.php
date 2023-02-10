<?php

namespace KUHdo\LaravelAuth0Migrator\Tests;

use Illuminate\Foundation\Application;
use KUHdo\LaravelAuth0Migrator\LaravelAuth0MigratorServiceProvider;
use Orchestra\Testbench\TestCase;

class TestCaseWithEnv extends TestCase
{
    protected $loadEnvironmentVariables = true;

    /**
     * Get package providers.
     *
     *
     */
    protected function getPackageProviders($app): array
    {
        return [
          LaravelAuth0MigratorServiceProvider::class,
        ];
    }

    /**
     * Define database migrations.
     *
     */
    protected function defineDatabaseMigrations(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
    }

    /**
     * Define environment setup.
     *
     *
     */
    protected function defineEnvironment($app): void
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver'   => 'sqlite',
            'database' => env('DB_DATABASE') ?? ':memory:',
            'prefix'   => '',
        ]);
    }
}
