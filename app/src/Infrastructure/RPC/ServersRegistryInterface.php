<?php

declare(strict_types=1);

namespace App\Infrastructure\RPC;

use App\Infrastructure\RPC\ValueObject\Server;

interface ServersRegistryInterface
{
    /**
     * @param non-empty-string $name
     * @param string $host
     */
    public function addServer(string $name, string $host): void;

    /**
     * @return Server[]
     */
    public function getServers(): array;

    public function getServer(string $name): ?Server;
}
