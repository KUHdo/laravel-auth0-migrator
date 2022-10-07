<?php

test('that the config has an auth0 entry', function () {
    $config = config('auth0-migrator.auth0');
    $this->assertNotNull($config);
});
test('that the config a management token can be read from envs', function () {
    $config = config('auth0-migrator.auth0.management_api_token');
    $this->assertNotNull($config);
});
test('that the client id is loaded from env', function () {
    $clientId = config('auth0-migrator.auth0.client_id');
    $this->assertNotNull($clientId);
});
test('that the client secret is loaded from env', function () {
    $clientId = config('auth0-migrator.auth0.client_secret');
    $this->assertNotNull($clientId);
});
test('that the domain is loaded from env', function () {
    $clientId = config('auth0-migrator.auth0.domain');
    $this->assertNotNull($clientId);
});