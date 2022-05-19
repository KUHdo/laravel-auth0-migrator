<?php

use KUHdo\LaravelAuth0Migrator\LaravelAuth0Migrator;
use KUHdo\LaravelAuth0Migrator\Facades\LaravelAuth0Migrator as LaravelAuth0MigratorFacade;

test('that the facade is instantiable', function(){
   $this->assertInstanceOf(LaravelAuth0Migrator::class, LaravelAuth0MigratorFacade::getFacadeRoot());
});

it('has all needed env vars as configuration', function() {
    LaravelAuth0MigratorFacade::managementApiClient();
});