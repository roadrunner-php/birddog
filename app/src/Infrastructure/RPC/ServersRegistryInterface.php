<?php

declare(strict_types=1);

namespace App\Infrastructure\RPC;

use Psr\Http\Message\UriInterface;

interface ServersRegistryInterface
{
    /**
     * @param non-empty-string $name
     * @param string $host
     */
    public function addServer(string $name, string $host): void;

    /**
     * @return non-empty-string[]
     */
    public function getServersNames(): array;

    public function getServerAddress(string $name): ?UriInterface;
}
