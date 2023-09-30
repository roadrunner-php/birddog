<?php

declare(strict_types=1);

namespace App\Application\Collectors;

use App\Application\Centrifuge\Channel\ServerChannel;
use App\Application\Command\Informer\PluginListQuery;
use App\Domain\Server\Collector\CollectorInterface;
use App\Infrastructure\RoadRunner\RPC\ValueObject\Server;
use App\Interfaces\HTTP\DataGrid\v1\Plugin\WorkersSchema;
use App\Interfaces\HTTP\Resource\v1\Plugin\PluginResource;
use App\Module\Informer\DTO\Plugin;
use Psr\Container\ContainerInterface;
use Spiral\Broadcasting\BroadcastInterface;

final readonly class PluginCollector implements CollectorInterface
{
    public function __construct(
        private BroadcastInterface $broadcast,
        private ContainerInterface $container,
    ) {
    }

    public function canCollect(Plugin $plugin): bool
    {
        return true;
    }

    public function collect(Server $server, Plugin $plugin): void
    {
        $schema = $this->container->get(WorkersSchema::class);
        $plugin = $plugin->jsonSerialize();
        $plugin['workers'] = $schema->create($plugin['workers']);

        $this->broadcast->publish(
            new ServerChannel($server->name),
            \json_encode([
                'event' => 'plugin.list',
                'data' => new PluginResource($plugin),
            ])
        );
    }
}
