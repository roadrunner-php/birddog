<?php

declare(strict_types=1);

namespace App\RPC;

final class ServersRegistry implements ServersRegistryInterface
{
    /**
     * @var array<string, array{
     *     addess: non-empty-string
     * }>
     */
    private array $servers;

    public function __construct(
        ServersConfig $config
    ) {
        $this->servers = $config->getServers();
    }

    public function getServersNames(): array
    {
        return \array_keys($this->servers);
    }

    public function getServerAddress(string $name): ?string
    {
        if (isset($this->servers[$name]['address'])) {
            return $this->servers[$name]['address'];
        }

        return null;
    }

    public function addServer(string $name, string $host): void
    {
        $this->servers[$name] = [
            'address' => $host,
        ];
    }
}
