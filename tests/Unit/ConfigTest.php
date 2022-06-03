<?php

test('that the config has an auth0 entry', function(){
    $config = config('auth0-migrator.auth0');
    $this->assertNotNull($config);
});

