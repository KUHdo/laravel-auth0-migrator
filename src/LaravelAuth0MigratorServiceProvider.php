<?php

namespace Kuhdo\LaravelAuth0Migrator;

use Auth0\SDK\Auth0;
use Auth0\SDK\Configuration\SdkConfiguration;
use Auth0\SDK\Contract\API\ManagementInterface;
use Auth0\SDK\Contract\Auth0Interface;
use Auth0\SDK\Contract\ConfigurableContract;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use Kuhdo\LaravelAuth0Migrator\Commands\JobStatusCommand;
use Kuhdo\LaravelAuth0Migrator\Facades\LaravelAuth0Migrator as LaravelAuth0MigratorFacade;
use Kuhdo\LaravelAuth0Migrator\Commands\MigrationCommand;

class LaravelAuth0MigratorServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'kuhdo');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/laravel-auth0-migrator.php', 'laravel-auth0-migrator');

        // Register the service the package provides.
        $this->app->singleton('laravel-auth0-migrator', function ($app) {
            return new LaravelAuth0Migrator(resolve(Auth0Interface::class));
        });

        $loader = AliasLoader::getInstance();
        $loader->alias('Auth0Migrator', LaravelAuth0MigratorFacade::class);

        // Shipping config from env vars.
        $this->app->singleton(ConfigurableContract::class, function($app) {
            return new SdkConfiguration(
                domain: config('auth0.domain'),
                clientId: config('auth0.client_id'),
                clientSecret: config('auth0.client_secret'),
                /*
                 * The process for retrieving an Access Token for Management API endpoints is described here:
                 * @link https://auth0.com/docs/libraries/auth0-php/using-the-management-api-with-auth0-php
                 */
                audience: config('auth0.audience'),
                organization: [ config('auth0.organization') ],
            );
        });

        // Binding auth0 interface to actual auth0 sdk implementation.
        $this->app->singleton(Auth0Interface::class, function($app) {
            return new Auth0(resolve(ConfigurableContract::class));
        });

        // Configuring management api on resolving.
        $this->app->singleton(ManagementInterface::class, function(App $app) {
            if (!is_null(config('auth0.organization'))) {
                $newConfiguredAuth0 = resolve(Auth0Interface::class)
                    ->configuration()
                    ->setManagementToken(config('auth0.management_api_token'));
                $this->app->instance(Auth0Interface::class, $newConfiguredAuth0);
            }

            /*
             * Create a configured instance of the `Auth0\SDK\API\Management` class,
             * based on the configuration we setup the SDK ($auth0) using.
             * If no AUTH0_MANAGEMENT_API_TOKEN is configured, this will automatically
             * perform a client credentials exchange to generate one for you, so long as a client secret is configured.
             */
            return  $newConfiguredAuth0->management();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['laravel-auth0-migrator'];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole(): void
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/laravel-auth0-migrator.php' => config_path('laravel-auth0-migrator.php'),
        ], 'laravel-auth0-migrator.config');

        // Registering package commands.
        $this->commands([
            MigrationCommand::class,
            JobStatusCommand::class,
        ]);
    }
}
