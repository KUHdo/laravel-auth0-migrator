#<?php

test('The aut0 sdk is successfully bineded', function() {
   $auth0 = $this->app->make(\Auth0\SDK\Contract\Auth0Interface::class);
   $this->assertInstanceOf(\Auth0\SDK\Contract\Auth0Interface::class, $auth0);
});