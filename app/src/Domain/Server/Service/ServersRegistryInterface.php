<?php

declare(strict_types=1);

namespace App\Domain\Server\Service;

/**
 * @psalm-type TName = non-empty-string
 * @psalm-type THost = non-empty-string
 */
interface ServersRegistryInterface
{
    /**
     * Add server to the registry.
     *
     * @param TName $name
     * @param THost $host
     */
    public function addServer(string $name, string $host): void;
}
