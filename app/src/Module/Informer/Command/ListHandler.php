<?php

declare(strict_types=1);

namespace App\Module\Informer\Command;

use App\Application\Command\Informer\ListQuery;
use App\Application\Command\Informer\WorkersQuery;
use App\Infrastructure\RPC\RPCManagerInterface;
use App\Module\Informer\Schema\PluginsSchema;
use Spiral\Cqrs\Attribute\QueryHandler;
use Spiral\Cqrs\QueryBusInterface;
use Spiral\DataGrid\GridInterface;
use Spiral\Goridge\RPC\Codec\JsonCodec;

final class ListHandler
{
    public function __construct(
        private readonly RPCManagerInterface $rpc,
        private readonly QueryBusInterface $queryBus,
        private readonly PluginsSchema $schema
    ) {
    }

    #[QueryHandler]
    public function __invoke(ListQuery $query): GridInterface
    {
        $rpc = $this->rpc->getServer($query->server, new JsonCodec());

        $plugins = $rpc->call('informer.List', null);
        $resettablePlugins = $rpc->call('resetter.List', null);

        return $this->schema->create(
            \array_map(fn(string $plugin): array => [
                'name' => $plugin,
                'is_ressetable' => \in_array($plugin, $resettablePlugins, true),
                'workers' => $this->queryBus->ask(new WorkersQuery($query->server, $plugin)),
            ], $plugins)
        );
    }
}
