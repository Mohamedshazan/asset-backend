<?php

return [
    'paths' => ['api/*', 'sanctum/csrf-cookie'],  // cors enabled for api routes

    'allowed_methods' => ['*'],

    'allowed_origins' => [
        'https://frontend-shazan-0d806d81.koyeb.app',  // your deployed frontend URL here
        // or use '*' to allow all origins temporarily during testing
    ],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true,
];