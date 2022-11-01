<?php

declare(strict_types=1);

/**
 * @return array{
 *     default: non-empty-string|null,
 *     servers: array<non-empty-string, array{
 *          address: non-empty-string,
 *     }>
 * }
 */
return [
    'default' => env('DEFAULT_RPC_SERVER', 'local'),
    'servers' => [
        //Address of Roadrunner RPC server
        'local' => [
           'address' => 'tcp://127.0.0.1:6001',
        ]
    ],
];
