<?php

declare(strict_types=1);

namespace App\HTTP\Controller\Jobs;

use App\CQRS\Query\Jobs\PipelineListQuery;
use App\HTTP\Request\Jobs\ListRequest;
use Spiral\Cqrs\QueryBusInterface;
use Spiral\Router\Annotation\Route;

final class PipelinesListAction
{
    #[Route('/jobs/pipelines', name: 'api.jobs.pipeline.list', methods: 'GET')]
    public function __invoke(QueryBusInterface $bus, ListRequest $request): array
    {
        return $bus->ask(new PipelineListQuery($request->server));
    }
}
