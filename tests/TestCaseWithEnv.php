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
     * @param  Application  $app
     *
     * @return array<int, class-string>
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
     * @return void
     */
    protected function defineDatabaseMigrations(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
    }

    /**
     * Define environment setup.
     *
     * @param  Application  $app
     *
     * @return void
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

        // Setup default database to use sqlite :memory:
        $app['config']->set('auth0-migrator.auth0', [
            'management_api_token' => env('AUTH0_MANAGEMENT_API_TOKEN'),
            'domain' => env('AUTH0_DOMAIN', 'YOUR_TENANT.auth0.com'),
            'client_id' => env('AUTH0_CLIENT_ID'),
            'client_secret' => env('AUTH0_CLIENT_SECRET'),
            // The process for retrieving an Access Token for Management API endpoints is described here:
            // https://auth0.com/docs/libraries/auth0-php/using-the-management-api-with-auth0-php
            'audience' => env('AUTH0_AUDIENCE'),
            'organization' => env('AUTH0_ORGANIZATION_ID'),
        ]);
    }
}
