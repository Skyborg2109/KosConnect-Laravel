<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cloudinary Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your Cloudinary settings. Cloudinary is a cloud
    | hosted media management service.
    |
    */

    'cloud_url' => env('CLOUDINARY_URL'),
    
    /**
     * Cloudinary Configuration
     */
    'cloud' => [
        'cloud_name' => parse_url(env('CLOUDINARY_URL'), PHP_URL_HOST),
        'api_key'    => parse_url(env('CLOUDINARY_URL'), PHP_URL_USER),
        'api_secret' => parse_url(env('CLOUDINARY_URL'), PHP_URL_PASS),
    ],

    'notification_url' => env('CLOUDINARY_NOTIFICATION_URL'),
];
