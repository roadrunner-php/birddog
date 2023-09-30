<?php

declare(strict_types=1);

namespace App\Module\Informer\Command;

use App\Application\Command\Informer\DTO\WorkersResult;
use App\Application\Command\Informer\WorkersQuery;
use App\Infrastructure\RoadRunner\RPC\RPCManagerInterface;
use App\Module\Informer\DTO\Worker;
use Carbon\Carbon;
use Spiral\Cqrs\Attribute\QueryHandler;

final readonly class WorkersHandler
{
    public function __construct(
        private RPCManagerInterface $rpc,
    ) {
    }

    #[QueryHandler]
    public function __invoke(WorkersQuery $query): WorkersResult
    {
        return new WorkersResult(
            server: $query->server,
            plugin: $query->plugin,
            workers: \array_map(
                fn(array $worker): Worker => new Worker(
                    cpuPercent: (float)$worker['CPUPercent'],
                    command: $worker['command'],
                    createdAt: Carbon::createFromTimestampMs((int)($worker['created'] / 1_000_000)),
                    memoryUsage: $worker['memoryUsage'],
                    pid: (int)$worker['pid'],
                    numExecs: (int)$worker['numExecs'],
                    status: (int)$worker['status'],
                    statusString: $worker['statusStr'],
                ),
                $this->rpc->connect($query->server)->pluginWorkers($query->plugin),
            ),
        );
    }
}
