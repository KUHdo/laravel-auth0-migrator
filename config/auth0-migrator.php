<?php

return [
    "auth0" => [
        "management_api_token" => env("AUTH0_MANAGEMENT_API_TOKEN"),
        // If you get an error that the domain is not configured
        // check if the domain matches to the application credentials (client_id, client_secret).
        "domain" => env('AUTH0_DOMAIN'),
        "connection_id" => env("MIGRATOR_AUTH0_CONNECTION_ID"),
    ],
    "storage" => [
        "path_prefix" => env("MIGRATOR_PATH_PREFIX", ""),
    ],
];
