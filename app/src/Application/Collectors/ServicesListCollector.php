<?php

declare(strict_types=1);

namespace App\Application\Collectors;

use App\Application\Centrifuge\Channel\ServerChannel;
use App\Application\Command\Service\ListQuery;
use App\Application\Command\Service\StatusQuery;
use App\Domain\Server\Collector\CollectorInterface;
use App\Infrastructure\RoadRunner\RPC\ValueObject\Server;
use App\Interfaces\HTTP\Resource\v1\Service\ServicesCollection;
use App\Module\Informer\DTO\Plugin;
use Spiral\Broadcasting\BroadcastInterface;
use Spiral\Cqrs\QueryBusInterface;

final readonly class ServicesListCollector implements CollectorInterface
{
    public function __construct(
        private QueryBusInterface $bus,
        private BroadcastInterface $broadcast,
    ) {
    }

    public function canCollect(Plugin $plugin): bool
    {
        return $plugin->name === 'services';
    }

    public function collect(Server $server, Plugin $plugin): void
    {
//        $services = \array_map(
//            static fn(string $service): array => ['name' => $service],
//            $this->bus->ask(new ListQuery($server->name)),
//        );
//
//        foreach ($services as &$service) {
//            $service['statuses'] = $this->bus->ask(new StatusQuery($server->name, $service['name']));
//        }
//
//        $this->broadcast->publish(
//            new ServerChannel($server->name),
//            (string)new ServicesListEvent(new ServicesCollection($services)),
//        );
    }
}
