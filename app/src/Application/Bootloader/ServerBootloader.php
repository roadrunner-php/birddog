<?php

declare(strict_types=1);

namespace App\Application\Bootloader;

use App\Application\Config\ServersConfig;
use App\Application\Tokenizer\DataCollectorTokenizerListener;
use App\Domain\Server\Collector\DataCollectorRegistryInterface;
use App\Domain\Server\Collector\DataCollectorRepositoryInterface;
use App\Domain\Server\Infrastructure\Cache\ServersRegistry;
use App\Domain\Server\Service\ServersRegistryInterface;
use App\Domain\Server\Service\ServersRepositoryInterface;
use Spiral\Boot\Bootloader\Bootloader;
use Spiral\Boot\EnvironmentInterface;
use Spiral\Cache\CacheStorageProviderInterface;
use Spiral\Tokenizer\TokenizerListenerRegistryInterface;

final class ServerBootloader extends Bootloader
{
    public function defineSingletons(): array
    {
        return [
            DataCollectorRegistryInterface::class => DataCollectorTokenizerListener::class,
            DataCollectorRepositoryInterface::class => DataCollectorTokenizerListener::class,

            ServersRegistry::class => [self::class, 'initServersRegistry'],
            ServersRegistryInterface::class => ServersRegistry::class,
            ServersRepositoryInterface::class => ServersRegistry::class,
        ];
    }

    public function boot(
        TokenizerListenerRegistryInterface $registry,
        DataCollectorTokenizerListener $collectorListener,
    ): void {
        $registry->addListener($collectorListener);
    }

    private function initServersRegistry(
        CacheStorageProviderInterface $provider,
        ServersConfig $config,
        EnvironmentInterface $env,
    ): ServersRegistryInterface {
        $registry = new ServersRegistry(
            $provider->storage('settings'),
            $config->getDefaultServer(),
            $config->getServers(),
        );

        foreach ($env->getAll() as $key => $host) {
            if (\str_starts_with($key, 'RPC_SERVER_')) {
                /** @var non-empty-string $name */
                $name = \strtolower(\str_replace('RPC_SERVER_', '', $key));
                $registry->addServer($name, $host);
            }
        }

        return $registry;
    }
}
