<?php

declare(strict_types=1);

namespace App\Module\Informer\Command;

use App\Application\Command\Informer\DTO\PluginListResult;
use App\Application\Command\Informer\PluginListQuery;
use App\Application\Command\Informer\WorkersQuery;
use App\Infrastructure\RoadRunner\RPC\RPCManagerInterface;
use App\Module\Informer\DTO\Plugin;
use Spiral\Cqrs\Attribute\QueryHandler;
use Spiral\Cqrs\QueryBusInterface;

final readonly class ListHandler
{
    public function __construct(
        private RPCManagerInterface $rpc,
        private QueryBusInterface $queryBus,
    ) {
    }

    #[QueryHandler]
    public function __invoke(PluginListQuery $query): PluginListResult
    {
        $rpc = $this->rpc->connect($query->server);

        $plugins = $rpc->pluginList();
        $resettablePlugins = $rpc->resettablePluginList();

        return new PluginListResult(
            server: $query->server,
            plugins: \array_map(fn(string $plugin): Plugin => new Plugin(
                name: $plugin,
                isResettable: \in_array($plugin, $resettablePlugins, true),
                workers: $this->queryBus->ask(new WorkersQuery($query->server, $plugin))->workers,
            ), $plugins),
        );
    }
}
