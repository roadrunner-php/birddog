<?php

declare(strict_types=1);

$servers = [];
$default = env('DEFAULT_RPC_SERVER', 'default');

if ($default === 'default') {
    $servers[$default] = [
        'address' => env('DEFAULT_RPC_SERVER_ADDRESS'),
    ];
}

/**
 * @return array{
 *     default: non-empty-string|null,
 *     servers: array<non-empty-string, array{
 *          address: non-empty-string,
 *     }>
 * }
 */
return [
    'default' => $default,
    'servers' => $servers,
];
