<?php

declare(strict_types=1);

namespace App\CQRS\Query\Informer;

use App\RPC\RPCManagerInterface;
use Spiral\Cqrs\Attribute\QueryHandler;
use Spiral\Goridge\RPC\Codec\JsonCodec;

final class ListHandler
{
    public function __construct(
        private readonly RPCManagerInterface $rpc,
    ) {
    }

    #[QueryHandler]
    /**
     * @return non-empty-string[]
     */
    public function __invoke(ListQuery $query): array
    {
        $rpc = $this->rpc->getServer($query->server, new JsonCodec());

        $plugins = $rpc->call('informer.List', null);
        $resettablePlugins = $rpc->call('resetter.List', null);

        return [
            'plugins' => \array_map(static fn(string $plugin) => [
                'name' => $plugin,
                'is_ressetable' => \in_array($plugin, $resettablePlugins, true),
                'workers' => $rpc->call('informer.Workers', $plugin)['workers'] ?? [],
            ], $plugins)
        ];
    }
}
