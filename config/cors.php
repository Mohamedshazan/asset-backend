<?php

return [
    'paths' => ['api/*', 'sanctum/csrf-cookie'],  // cors enabled for api routes

    'allowed_methods' => ['*'],

    'allowed_origins' => [
        'https://shiham-brandix-batti-assetsystem-d4sd.vercel.app',  // your deployed frontend URL here
        // or use '*' to allow all origins temporarily during testing
    ],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true,
];
