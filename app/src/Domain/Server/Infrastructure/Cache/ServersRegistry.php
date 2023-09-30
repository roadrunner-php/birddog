<?php

declare(strict_types=1);

namespace App\Domain\Server\Infrastructure\Cache;

use App\Application\Config\ServersConfig;
use App\Domain\Server\Service\ServersRegistryInterface;
use App\Domain\Server\Service\ServersRepositoryInterface;
use App\Infrastructure\RoadRunner\RPC\ValueObject\Server;
use Psr\SimpleCache\CacheInterface;
use Psr\SimpleCache\InvalidArgumentException;

/**
 * @psalm-import-type TName from ServersRegistryInterface
 * @psalm-import-type THost from ServersRegistryInterface
 * @psalm-type TServerArray
 */
final readonly class ServersRegistry implements ServersRegistryInterface, ServersRepositoryInterface
{
    /**
     * @param array<TName, THost> $servers
     * @throws InvalidArgumentException
     */
    public function __construct(
        private CacheInterface $cache,
        private ?string $default,
        array $servers = [],
    ) {
        foreach ($servers as $name => $address) {
            $this->addServer($name, $address);
        }
    }

    public function getDefault(): ?string
    {
        return $this->default;
    }

    /**
     * @throws InvalidArgumentException
     */
    public function getServers(): array
    {
        return \array_values($this->getServersFromCache());
    }

    /**
     * @throws InvalidArgumentException
     */
    public function getServer(string $name): ?Server
    {
        $servers = $this->getServersFromCache();

        return $servers[$name] ?? null;
    }

    /**
     * @throws InvalidArgumentException
     */
    public function addServer(string $name, string $host): void
    {
        $servers = $this->getServersFromCache();
        $servers[$name] = new Server($name, $host);
        $this->storeServers($servers);
    }

    /**
     * @return array<non-empty-string, Server>
     * @throws InvalidArgumentException
     */
    private function getServersFromCache(): array
    {
        return \array_map(
            static fn(array $server): Server => Server::fromArray($server),
            $this->cache->get('servers', []),
        );
    }

    /**
     * @param Server[] $servers
     * @throws InvalidArgumentException
     */
    private function storeServers(array $servers): void
    {
        $this->cache->set(
            'servers',
            \array_map(fn(Server $server): array => $server->jsonSerialize(), $servers),
        );
    }
}
