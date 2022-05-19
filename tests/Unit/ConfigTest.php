<?php

test('that the config has an auth0 entry', function(){
   $this->assertNotNull(config('laravel-auth0-migrator.auth0'));
});