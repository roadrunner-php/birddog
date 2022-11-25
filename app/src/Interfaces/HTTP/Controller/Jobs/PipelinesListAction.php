<?php

declare(strict_types=1);

namespace App\Interfaces\HTTP\Controller\Jobs;

use App\Application\Command\Jobs\PipelineListQuery;
use App\Application\HTTP\Response\ResourceInterface;
use Spiral\Cqrs\QueryBusInterface;
use Spiral\Router\Annotation\Route;

final class PipelinesListAction
{
    #[Route('jobs/pipelines', name: 'jobs.pipeline.list', methods: 'GET')]
    public function __invoke(QueryBusInterface $bus, ListRequest $request): ResourceInterface
    {
        return new PipelineCollection(
            $bus->ask(new PipelineListQuery($request->server))
        );
    }
}
