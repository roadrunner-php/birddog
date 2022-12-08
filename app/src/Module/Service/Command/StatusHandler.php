<?php

declare(strict_types=1);

namespace App\Module\Service\Command;

use App\Application\Command\RoadRunner\GetVersionQuery;
use App\Application\Command\Service\StatusQuery;
use App\Infrastructure\RPC\RPCManagerInterface;
use Spiral\Cqrs\Attribute\QueryHandler;
use Spiral\Cqrs\QueryBusInterface;
use Spiral\RoadRunner\Services\Manager;

final class StatusHandler
{
    public function __construct(
        private readonly RPCManagerInterface $rpc,
        private readonly QueryBusInterface $queryBus
    ) {
    }

    #[QueryHandler]
    public function __invoke(StatusQuery $query): array
    {
        $version = $this->queryBus->ask(new GetVersionQuery($query->server))['version'];
        $manager = new Manager($this->rpc->getServer($query->server));

        if ($version === null) {
            $status = $manager->status($query->service);
            $status['error'] = null;
            $statuses = [$status];
        } else {
            $statuses = $manager->statuses($query->service);
        }

        return [
            'statuses' => $statuses,
        ];
    }
}
