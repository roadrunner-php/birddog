<?php

declare(strict_types=1);

namespace App\Module\Service\Command;

use App\Application\Command\Service\DTO\StatusResult;
use App\Application\Command\Service\StatusQuery;
use App\Infrastructure\RoadRunner\RPC\RPCManagerInterface;
use App\Module\Service\Command\DTO\Status;
use Spiral\Cqrs\Attribute\QueryHandler;
use Spiral\RoadRunner\Services\Manager;

final readonly class StatusHandler
{
    public function __construct(
        private RPCManagerInterface $rpc,
    ) {
    }

    #[QueryHandler]
    public function __invoke(StatusQuery $query): StatusResult
    {
        $manager = new Manager($this->rpc->connect($query->server)->getRpc());

        $statuses = \array_map(
            static fn(array $status): Status => new Status(
                command: $status['command'],
                cpuPercent: $status['cpu_percent'],
                memoryUsage: $status['memory_usage'],
                pid: $status['pid'],
                error: $status['error']['message'] ?? null,
            ),
            $manager->statuses($query->service),
        );

        return new StatusResult(
            server: $query->server,
            service: $query->service,
            statuses: $statuses,
        );
    }
}
