<?php

namespace Kuhdo\LaravelAuth0Migrator;

use Illuminate\Support\ServiceProvider;

class LaravelAuth0MigratorServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'kuhdo');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'kuhdo');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

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
            return new LaravelAuth0Migrator;
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

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/kuhdo'),
        ], 'laravel-auth0-migrator.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/kuhdo'),
        ], 'laravel-auth0-migrator.views');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/kuhdo'),
        ], 'laravel-auth0-migrator.views');*/

        // Registering package commands.
        // $this->commands([]);
    }
}
