<?php

declare(strict_types=1);

namespace App\Interfaces\HTTP\Controller\v1\Jobs\Pipeline;

use App\Application\Command\Jobs\PipelineListQuery;
use App\Application\HTTP\Response\ResourceInterface;
use App\Interfaces\HTTP\DataGrid\v1\Jobs\PipelinesSchema;
use App\Interfaces\HTTP\Filter\v1\Jobs\ListRequest;
use App\Interfaces\HTTP\Resource\v1\Jobs\PipelineCollection;
use Spiral\Cqrs\QueryBusInterface;
use Spiral\Router\Annotation\Route;

final readonly class ListAction
{
    public function __construct(
        private PipelinesSchema $schema,
    ) {
    }

    #[Route('jobs/pipelines', name: 'jobs.pipeline.list', methods: 'GET')]
    public function __invoke(QueryBusInterface $bus, ListRequest $request): ResourceInterface
    {
        $result = $bus->ask(new PipelineListQuery($request->server));

        return new PipelineCollection(
            $this->schema->create($result->pipelines),
        );
    }
}
