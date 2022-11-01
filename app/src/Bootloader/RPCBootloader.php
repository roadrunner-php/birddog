<?php

declare(strict_types=1);

namespace App\Bootloader;

use App\RPC\RPCManager;
use App\RPC\RPCManagerInterface;
use App\RPC\ServersRegistry;
use App\RPC\ServersRegistryInterface;
use Spiral\Boot\Bootloader\Bootloader;
use Spiral\Boot\EnvironmentInterface;

final class RPCBootloader extends Bootloader
{
    protected const SINGLETONS = [
        RPCManagerInterface::class => RPCManager::class,
        ServersRegistryInterface::class => ServersRegistry::class,
    ];

    public function boot(ServersRegistryInterface $registry, EnvironmentInterface $env)
    {
        foreach ($env->getAll() as $key => $host) {
            if (\str_starts_with($key, 'RPC_SERVER_')) {
                $name = \strtolower(\str_replace('RPC_SERVER_', '', $key));
                $registry->addServer($name, $host);
            }
        }
    }
}
