<?php

declare(strict_types=1);

namespace App\Application\Collectors;

use App\Application\Centrifuge\Channel\ServerChannel;
use App\Application\Command\Jobs\PipelineListQuery;
use App\Domain\Server\Collector\CollectorInterface;
use App\Infrastructure\RoadRunner\RPC\ValueObject\Server;
use App\Interfaces\HTTP\DataGrid\v1\Jobs\PipelinesSchema;
use App\Interfaces\HTTP\Resource\v1\Jobs\PipelineCollection;
use App\Module\Informer\DTO\Plugin;
use Psr\Container\ContainerInterface;
use Spiral\Broadcasting\BroadcastInterface;
use Spiral\Cqrs\QueryBusInterface;

final readonly class PipelinesListCollector implements CollectorInterface
{
    public function __construct(
        private QueryBusInterface $bus,
        private BroadcastInterface $broadcast,
        private ContainerInterface $container,
    ) {
    }

    public function canCollect(Plugin $plugin): bool
    {
        return $plugin->name === 'jobs';
    }

    public function collect(Server $server, Plugin $plugin): void
    {
        $schema = $this->container->get(PipelinesSchema::class);

        $this->broadcast->publish(
            new ServerChannel($server->name),
            \json_encode([
                'event' => 'pipelines.list',
                'data' => new PipelineCollection(
                    $schema->create(
                        $this->bus->ask(new PipelineListQuery($server->name)),
                    ),
                ),
            ]),
        );
    }
}
