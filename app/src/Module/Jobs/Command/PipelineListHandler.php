<?php

declare(strict_types=1);

namespace App\Module\Jobs\Command;

use App\Application\Command\Jobs\PipelineListQuery;
use App\Infrastructure\RPC\RPCManagerInterface;
use App\Module\Jobs\Schema\PipelinesSchema;
use Spiral\Cqrs\Attribute\QueryHandler;
use Spiral\DataGrid\GridInterface;
use Spiral\RoadRunner\Jobs\Jobs;
use Spiral\RoadRunner\Jobs\Queue;

final class PipelineListHandler
{
    public function __construct(
        private readonly RPCManagerInterface $rpc,
        private readonly PipelinesSchema $schema,
    ) {
    }

    #[QueryHandler]
    public function __invoke(PipelineListQuery $query): GridInterface
    {
        $rpc = $this->rpc->getServer($query->server);
        $jobs = new Jobs($rpc);

        $pipelines = [];

        $queues = \iterator_to_array($jobs->getIterator());
        foreach ($queues as $queue) {
            /** @var Queue $queue */
            $stat = $queue->getPipelineStat();

            $pipelines[] = [
                'name' => $stat->getPipeline(),
                'driver' => $stat->getDriver(),
                'priority' => $stat->getPriority(),
                'active' => $stat->getActive(),
                'delayed' => $stat->getDelayed(),
                'reserved' => $stat->getReserved(),
                'ready' => $stat->getReady(),
            ];
        }

        return $this->schema->create($pipelines);
    }
}
