<?php

use KUHdo\LaravelAuth0Migrator\Auth0Migrator;
use KUHdo\LaravelAuth0Migrator\Facades\Auth0Migrator as Auth0MigratorFacade;

test('that the facade is instantiable', function () {
    $this->assertInstanceOf(Auth0Migrator::class, Auth0MigratorFacade::getFacadeRoot());
});

it('has all needed env vars as configuration', function () {
    $managementClient = Auth0MigratorFacade::managementApiClient();
});
