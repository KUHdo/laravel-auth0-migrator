<?php

return [
    "auth0" => [
        "management_api_token" => env("AUTH0_MANAGEMENT_API_TOKEN"),
        // If you get an error that the domain is not configured
        // check if the domain matches to the application credentials (client_id, client_secret).
        "domain" => env('AUTH0_DOMAIN', 'YOUR_TENANT.auth0.com'),
        "client_id" => env('AUTH0_CLIENT_ID'),
        "client_secret" => env('AUTH0_CLIENT_SECRET'),
        # A long, secret value used to encrypt the session cookie.
        # This can be generated using `openssl rand -hex 32` from your shell.
        "cookie_secret" => env('AUTH0_COOKIE_SECRET'),
        // The process for retrieving an Access Token for Management API endpoints is described here:
        // https://auth0.com/docs/libraries/auth0-php/using-the-management-api-with-auth0-php
        "audience" => env("AUTH0_AUDIENCE"),
        "organization" => env("AUTH0_ORGANIZATION_ID"),
    ],
    "storage" => [
        "path_prefix" => env("PATH_PREFIX", ""),
    ],
];
