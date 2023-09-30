<?php

declare(strict_types=1);

use Spiral\Cache\Storage\ArrayStorage;
use Spiral\Cache\Storage\FileStorage;

return [

    /**
     * The default cache connection that gets used while using this caching library.
     */
    'default' => env('CACHE_STORAGE', 'roadrunner'),

    /**
     * Aliases, if you want to use domain specific storages.
     */
    'aliases' => [
        'settings' => 'local',
        'metrics' => 'local',
    ],

    /**
     * Here you may define all of the cache "storages" for your application as well as their types.
     */
    'storages' => [
        'roadrunner' => [
            'type' => 'roadrunner',
            'driver' => 'settings',
        ],
        'local' => [
            'type' => ArrayStorage::class,
        ],
    ],
];
