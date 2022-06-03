<?php

namespace KUHdo\LaravelAuth0Migrator\Tests;

use Illuminate\Foundation\Application;
use KUHdo\LaravelAuth0Migrator\LaravelAuth0MigratorServiceProvider;
use Orchestra\Testbench\TestCase;

class TestCaseWithEnv extends TestCase
{
    /**
     * Get package providers.
     *
     * @param  Application  $app
     * @return array<int, class-string>
     */
    protected function getPackageProviders($app): array
    {
        return [
          LaravelAuth0MigratorServiceProvider::class
        ];
    }

    /**
     * Define environment setup.
     *
     * @param  Application  $app
     * @return void
     */
    protected function defineEnvironment($app): void
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('auth0-migrator.auth0', [
            "management_api_token" => 'TOKEN',
            "domain" => 'YOUR_TENANT.auth0.com',
            "client_id" => 'YOU_ID',
            "client_secret" => 'YOUR_SECRET',
            // The process for retrieving an Access Token for Management API endpoints is described here:
            // https://auth0.com/docs/libraries/auth0-php/using-the-management-api-with-auth0-php
            "audience" => 'AUDIENCE',
            "organization" => 'ORG_ORG',
        ]);
    }
}