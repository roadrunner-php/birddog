<?php

declare(strict_types=1);

namespace App\Domain\Server\Collector;

use App\Application\Command\Informer\PluginListQuery;
use App\Domain\Server\Service\ServersRepositoryInterface;
use App\Module\Informer\DTO\Plugin;
use App\Module\Informer\DTO\Worker;
use Carbon\Carbon;
use Spiral\Cqrs\QueryBusInterface;

final readonly class DataCollector
{
    public function __construct(
        private ServersRepositoryInterface $servers,
        private DataCollectorRepositoryInterface $collectors,
        private QueryBusInterface $bus,
    ) {
    }

    public function collect(): void
    {
        foreach ($this->collectors->get() as $collector) {
            foreach ($this->servers->getServers() as $server) {
                $plugins = $this->bus->ask(new PluginListQuery($server->name))->plugins;

                foreach ($plugins as $plugin) {
                    if ($collector->canCollect($plugin)) {
                        $collector->collect($server, $plugin);
                    }
                }
            }
        }
    }
}
