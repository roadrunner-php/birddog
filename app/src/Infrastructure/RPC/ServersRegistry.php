<?php

declare(strict_types=1);

namespace App\Infrastructure\RPC;

use App\Infrastructure\RPC\ValueObject\Server;
use Psr\SimpleCache\CacheInterface;

final class ServersRegistry implements ServersRegistryInterface
{
    public function __construct(
        private readonly CacheInterface $cache,
        array $servers = [],
    ) {
        foreach ($servers as $name => $address) {
            $this->addServer($name, $address);
        }
    }

    public function getServers(): array
    {
        return \array_values($this->getServersFromCache());
    }

    public function getServer(string $name): ?Server
    {
        $servers = $this->getServersFromCache();

        return $servers[$name] ?? null;
    }

    public function addServer(string $name, string $host): void
    {
        $servers = $this->getServersFromCache();
        $servers[$name] = new Server($name, $host);
        $this->storeServers($servers);
    }

    /**
     * @return array<non-empty-string, Server>
     */
    private function getServersFromCache(): array
    {
        return \array_map(
            fn(array $server): Server => Server::fromArray($server),
            $this->cache->get('servers', []),
        );
    }

    private function storeServers(array $servers): void
    {
        $this->cache->set(
            'servers',
            \array_map(fn(Server $server): array => $server->jsonSerialize(), $servers)
        );
    }
}
