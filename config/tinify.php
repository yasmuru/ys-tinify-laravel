<?php

declare(strict_types=1);

return [
    /*
    |--------------------------------------------------------------------------
    | TinyPNG API Key
    |--------------------------------------------------------------------------
    |
    | Your TinyPNG API key. You can get one at https://tinypng.com/developers
    |
    */
    'apikey' => env('TINIFY_APIKEY'),

    /*
    |--------------------------------------------------------------------------
    | S3 Credentials
    |--------------------------------------------------------------------------
    |
    | Credentials used when storing compressed output directly to S3 via
    | the fileToS3 / bufferToS3 / urlToS3 helpers. Resolving these through
    | the config layer keeps the package compatible with `config:cache`.
    |
    */
    's3' => [
        'key'    => env('S3_KEY'),
        'secret' => env('S3_SECRET'),
        'region' => env('S3_REGION'),
    ],
];
