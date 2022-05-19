<?php

namespace KUHdo\LaravelAuth0Migrator\Facades;

use Illuminate\Support\Facades\Facade;

class LaravelAuth0Migrator extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'laravel-auth0-migrator';
    }
}
