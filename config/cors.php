<?php

return [
    'paths' => [
        'api/*',
        'login',
        'register',
        'sanctum/csrf-cookie'
    ],

    'allowed_methods' => ['*'],

    'allowed_origins' => [
        'https://shiham-brandix-batti-assetsystem-d4sd.vercel.app',
        'http://localhost:3000', // for local development
    ],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true,
];
