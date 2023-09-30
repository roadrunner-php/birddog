<?php

declare(strict_types=1);

namespace App\Application\Bootloader;

use App\Application\Config\ServersConfig;
use App\Domain\Server\Infrastructure\Cache\ServersRegistry;
use App\Domain\Server\Service\ServersRegistryInterface;
use App\Domain\Server\Service\ServersRepositoryInterface;
use App\Infrastructure\RoadRunner\RPC\RPCManager;
use App\Infrastructure\RoadRunner\RPC\RPCManagerInterface;
use Spiral\Boot\Bootloader\Bootloader;
use Spiral\Boot\EnvironmentInterface;
use Spiral\Cache\CacheStorageProviderInterface;

final class RPCBootloader extends Bootloader
{
    public function defineSingletons(): array
    {
        return [
            RPCManagerInterface::class => RPCManager::class,
        ];
    }
}
