<?php

use Auth0\SDK\Contract\ConfigurableContract;

it('can publish with tag', function () {
    $this->artisan('vendor:publish --tag=laravel-auth0-migrator')->assertSuccessful();
});

test('sdk config is a singleton', function () {
    $sdkConfig = resolve(ConfigurableContract::class);
    config()->set('auth0-migrator.auth0.domain', 'anotherDomain.com');
    $secondTime = resolve(ConfigurableContract::class);
    $this->assertEquals($sdkConfig, $secondTime);
});
