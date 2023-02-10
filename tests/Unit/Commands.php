<?php

use Auth0\SDK\Contract\API\ManagementInterface;
use Auth0\SDK\Contract\Auth0Interface;
use Auth0\SDK\Contract\ConfigurableContract;
use Orchestra\Testbench\Factories\UserFactory;

beforeEach(function () {
    UserFactory::new()->create();
});

it('can run migrate command', function () {
    $this->artisan('auth0:migrate')->assertSuccessful();
});

test('sdk config is a singleton', function () {
    $sdkConfig = resolve(ConfigurableContract::class);
    config()->set('auth0-migrator.auth0.domain', 'anotherDomain.com');
    $secondTime = resolve(ConfigurableContract::class);
    $this->assertEquals($sdkConfig, $secondTime);
});

test('the aut0 sdk is successfully bound', function () {
    $auth0 = resolve(Auth0Interface::class);
    $this->assertInstanceOf(Auth0Interface::class, $auth0);
});

test('auth0 management client can be resolved', function () {
    $auth0MgmtClient = resolve(ManagementInterface::class);
    $this->assertInstanceOf(ManagementInterface::class, $auth0MgmtClient);
});

test('migrate roles and permissions', function () {
    $this->artisan('auth0:migrate:roles-permissions')->assertSuccessful();
});