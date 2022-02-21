<?php

return [
    "auth0" => [
        "management_api_token" => env("AUTH0_MANAGEMENT_API_TOKEN", null),
        "domain" => env('AUTH0_DOMAIN', 'YOUR_TENANT.auth0.com'),
        "client_id" => env('AUTH0__CLIENT_ID', null),
        "client_secret" => env('AUTH0_CLIENT_SECRET', null),
        // The process for retrieving an Access Token for Management API endpoints is described here:
        // https://auth0.com/docs/libraries/auth0-php/using-the-management-api-with-auth0-php
        "audience" => env( "AUTH0_AUDIENCE", null),
        "organization" => env("AUTH0_YOUR_ORGANIZATION_ID", null),
    ],
];