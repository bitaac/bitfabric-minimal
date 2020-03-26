<?php

return [

    /*
    |--------------------------------------------------------------------------
    | The active theme used by bitaac.
    |--------------------------------------------------------------------------
    |
    |
    */

    'theme' => 'default',

    /*
    |--------------------------------------------------------------------------
    | Link used to display item images.
    |--------------------------------------------------------------------------
    |
    |
    */

    'item_images' => 'http://items.znote.eu/{item_id}.gif',

    /*
    |--------------------------------------------------------------------------
    | Application SSL
    |--------------------------------------------------------------------------
    |
    | Here you may specify whether the application should force a SSL (HTTPS)
    | mode across all pages and local URLs.
    |
    */

    'https' => env('APP_HTTPS', false),

    /*
    |--------------------------------------------------------------------------
    | Admin Theme service provider
    |--------------------------------------------------------------------------
    | Currently available:
    |     Bitaac\ThemeAdmin\ThemeAdminServiceProvider::class
    |
    */

    'theme-admin' => Bitaac\ThemeAdmin\ThemeAdminServiceProvider::class,

];
