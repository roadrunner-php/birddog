<?php

declare(strict_types=1);

namespace App\Module\Jobs\Command;

use App\Application\Command\Jobs\DTO\PipelineListResult;
use App\Application\Command\Jobs\PipelineListQuery;
use App\Infrastructure\RoadRunner\RPC\RPCManagerInterface;
use App\Module\Jobs\Command\DTO\Pipeline;
use Spiral\Cqrs\Attribute\QueryHandler;

final readonly class PipelineListHandler
{
    public function __construct(
        private RPCManagerInterface $rpc,
    ) {
    }

    #[QueryHandler]
    public function __invoke(PipelineListQuery $query): PipelineListResult
    {
        $pipelines = \array_map(
            static fn(array $pipeline): Pipeline => new Pipeline(
                pipeline: $pipeline['pipeline'],
                driver: $pipeline['driver'],
                queue: $pipeline['queue'],
                priority: $pipeline['priority'],
                active: $pipeline['active'],
                delayed: $pipeline['delayed'],
                reserved: $pipeline['reserved'],
                ready: $pipeline['ready'],
            ),
            $this->rpc->connect($query->server)->queuePipelineList(),
        );

        return new PipelineListResult(
            server: $query->server,
            pipelines: $pipelines,
        );
    }
}
