<?php

$d = DIRECTORY_SEPARATOR;

return [
    'redisDbIndex' => REDIS_DB_INDEX,
    'baseDomain' => 'BASE_DOMAIN',
    'baseUrl' => 'BASE_URL',
    'origins' => [
        'baseOrigin' => 'ORIGINS_BASE_ORIGIN',
        'allowedOrigins' => ORIGINS_ALLOWED_ARRAY
    ],
    'postgresql' => [
        'host' => '127.0.0.1',
        'port' => PG_PORT,
        'dbname' => 'PG_DB',
        'user' => 'PG_USER',
        'password' => 'PG_PASSWORD'
    ],
    'admins' => ADMINS_ARRAY,
    'hashSalt' => 'HASH_SALT',
    'publicDir' => __DIR__ . $d . '..' . $d . '..' . $d . 'files',
];
