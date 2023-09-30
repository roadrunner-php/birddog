<?php

declare(strict_types=1);

namespace App\Domain\Server\Service;

use App\Infrastructure\RoadRunner\RPC\ValueObject\Server;

/**
 * @psalm-import-type TName from ServersRegistryInterface
 */
interface ServersRepositoryInterface
{
    /**
     * Get default server.
     *
     * @return TName|null
     */
    public function getDefault(): ?string;

    /**
     * Get all registered servers.
     *
     * @return Server[]
     */
    public function getServers(): array;

    /**
     * Get server by name.
     *
     * @param TName $name
     */
    public function getServer(string $name): ?Server;
}
