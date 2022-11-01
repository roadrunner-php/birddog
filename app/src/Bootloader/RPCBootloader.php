<?php

declare(strict_types=1);

namespace App\Bootloader;

use App\RPC\RPCManager;
use App\RPC\RPCManagerInterface;
use App\RPC\ServersRegistry;
use App\RPC\ServersRegistryInterface;
use Spiral\Boot\Bootloader\Bootloader;

final class RPCBootloader extends Bootloader
{
    protected const SINGLETONS = [
        RPCManagerInterface::class => RPCManager::class,
        ServersRegistryInterface::class => ServersRegistry::class,
    ];
}
