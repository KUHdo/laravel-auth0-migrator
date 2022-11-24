<?php

namespace KUHdo\LaravelAuth0Migrator;

use Auth0\SDK\Auth0;
use Auth0\SDK\Configuration\SdkConfiguration;
use Auth0\SDK\Contract\API\ManagementInterface;
use Auth0\SDK\Contract\Auth0Interface;
use Auth0\SDK\Contract\ConfigurableContract;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use KUHdo\LaravelAuth0Migrator\Commands\JobErrorDetailsCommand;
use KUHdo\LaravelAuth0Migrator\Commands\JobStatusCommand;
use KUHdo\LaravelAuth0Migrator\Commands\MigrationCommand;
use KUHdo\LaravelAuth0Migrator\Contracts\UserMappingJsonSchema;

class LaravelAuth0MigratorServiceProvider extends ServiceProvider
{
    protected string $configFilePath = __DIR__.'/../config/auth0-migrator.php';

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'kuhdo');
        $this->publishConfig();

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole(): void
    {
        $this->publishConfig();

        // Registering package commands.
        $this->commands([
            MigrationCommand::class,
            JobStatusCommand::class,
            JobErrorDetailsCommand::class,
        ]);
    }

    /**
     * Publishing the configuration file.
     *
     * @return void
     */
    protected function publishConfig(): void
    {
        $this->publishes(
            [$this->configFilePath => config_path('auth0-migrator.php')],
            'config'
        );
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom($this->configFilePath, 'auth0-migrator');

        // Register the service the package provides.
        $this->app->singleton('laravel-auth0-migrator', function (Application $app) {
            return new Auth0Migrator(
                $app->make(Auth0Interface::class),
            );
        });

        $this->app->bind(UserMappingJsonSchema::class, UserMapping::class);
        // Shipping config from env vars.
        $this->app->singleton(ConfigurableContract::class, function () {
            return new SdkConfiguration(
                domain: config('auth0-migrator.auth0.domain'),
                clientId: config('auth0-migrator.auth0.client_id'),
                clientSecret: config('auth0-migrator.auth0.client_secret'),
                audience: [config('auth0-migrator.auth0.audience')],
                cookieSecret: config('auth0-migrator.auth0.cookie_secret'),
                managementToken: config('auth0-migrator.auth0.management_api_token')
            );
        });

        // Binding auth0 interface to actual auth0 sdk implementation.
        $this->app->bind(Auth0Interface::class, function (Application $app) {
            return new Auth0($app->make(ConfigurableContract::class));
        });

        /*
         * Create a configured instance of the `Auth0\SDK\API\Management` class,
         * based on the configuration we set up the SDK ($auth0) using.
         * If no AUTH0_MANAGEMENT_API_TOKEN is configured, this will automatically
         * perform a client credentials exchange to generate one for you, so long as a client secret is configured.
         */
        $this->app->singleton(ManagementInterface::class, function (Application $app) {
            if (! is_null(config('auth0-migrator.auth0.management_api_token'))) {
                $newConfiguration = $app->make(Auth0Interface::class)
                    ->configuration()
                    ->setManagementToken(config('auth0-migrator.auth0.management_api_token'));

                // Rebinding SDKConfiguration and Auth0Interface with new skd configuration.
                $this->app->instance(ConfigurableContract::class, $newConfiguration);
                $newAuth0 = new Auth0($newConfiguration);
                $this->app->instance(Auth0Interface::class, $newAuth0);
            }

            return $app->make(Auth0Interface::class)->management();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['auth0-migrator'];
    }
}
