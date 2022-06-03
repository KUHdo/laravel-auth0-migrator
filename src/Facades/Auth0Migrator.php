<?php

namespace KUHdo\LaravelAuth0Migrator\Facades;

use Illuminate\Support\Facades\Facade;

class Auth0Migrator extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'auth0-migrator';
    }
}
