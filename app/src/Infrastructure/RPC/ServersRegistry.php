<?php

declare(strict_types=1);

namespace App\Infrastructure\RPC;

use Nyholm\Psr7\Uri;
use Psr\Http\Message\UriInterface;
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

    public function getServersNames(): array
    {
        return \array_keys($this->getServersFromCache());
    }

    public function getServerAddress(string $name): ?UriInterface
    {
        $servers = $this->getServersFromCache();
        if (isset($servers[$name]['address'])) {
            return new Uri($servers[$name]['address']);
        }

        return null;
    }

    public function addServer(string $name, string $host): void
    {
        $servers = $this->getServersFromCache();
        $servers[$name] = ['address' => $host];
        $this->cache->set('servers', $servers);
    }

    /**
     * @return array<string, array{
     *     address: non-empty-string
     * }>
     */
    private function getServersFromCache(): array
    {
        return $this->cache->get('servers', []);
    }
}
