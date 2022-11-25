<?php

declare(strict_types=1);

namespace App\Application\Bootloader;

use App\Infrastructure\RPC\RPCManager;
use App\Infrastructure\RPC\RPCManagerInterface;
use App\Infrastructure\RPC\ServersConfig;
use App\Infrastructure\RPC\ServersRegistry;
use App\Infrastructure\RPC\ServersRegistryInterface;
use Spiral\Boot\Bootloader\Bootloader;
use Spiral\Boot\EnvironmentInterface;
use Spiral\Cache\CacheStorageProviderInterface;

final class RPCBootloader extends Bootloader
{
    protected const SINGLETONS = [
        RPCManagerInterface::class => RPCManager::class,
        ServersRegistryInterface::class => [self::class, 'initServersRegistry'],
    ];

    private function initServersRegistry(
        CacheStorageProviderInterface $provider,
        ServersConfig $config,
        EnvironmentInterface $env
    ): ServersRegistryInterface {
        $registry = new ServersRegistry(
            $provider->storage('settings'),
            $config->getServers()
        );

        foreach ($env->getAll() as $key => $host) {
            if (\str_starts_with($key, 'RPC_SERVER_')) {
                $name = \strtolower(\str_replace('RPC_SERVER_', '', $key));
                $registry->addServer($name, $host);
            }
        }

        return $registry;
    }
}
