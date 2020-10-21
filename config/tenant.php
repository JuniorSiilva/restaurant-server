<?php

return [
    'domain' => [
        'protocol' => env('TENANT_DOMAIN_PROTOCOL', 'http://'),

        'suffix' => env('TENANT_DOMAIN_SUFFIX'),
    ],

    'database' => [
        'host' => env('TENANT_DATABASE_HOST', '127.0.0.1'),
        'port' => env('TENANT_DATABASE_PORT', '5432'),
        'user' => env('TENANT_DATABASE_USER', 'postgres'),
        'password' => env('TENANT_DATABASE_PASSWORD', 'root'),
        'driver' => env('TENANT_DATABASE_DRIVER', 'pgsql'),
    ],
];
