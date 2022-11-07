<?php

declare(strict_types=1);

$servers = [];

$default = env('DEFAULT_RPC_SERVER', 'default');

if ($default === 'default') {
    $servers[$default] = env('DEFAULT_RPC_SERVER_ADDRESS', 'tcp://127.0.0.1:6001');
}

/**
 * @return array{
 *     default: non-empty-string|null,
 *     servers: array<non-empty-string, non-empty-string>
 * }
 */
return [
    'default' => $default,
    'servers' => $servers,
];
