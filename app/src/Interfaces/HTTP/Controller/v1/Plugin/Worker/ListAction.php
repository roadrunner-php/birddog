<?php

declare(strict_types=1);

namespace App\Interfaces\HTTP\Controller\v1\Plugin\Worker;

use App\Application\Command\Informer\WorkersQuery;
use App\Application\HTTP\Response\ResourceInterface;
use App\Interfaces\HTTP\DataGrid\v1\Plugin\WorkersSchema;
use App\Interfaces\HTTP\Filter\v1\Plugin\WorkerRequest;
use App\Interfaces\HTTP\Resource\v1\Plugin\WorkerCollection;
use Spiral\Cqrs\QueryBusInterface;
use Spiral\Router\Annotation\Route;

final readonly class ListAction
{
    public function __construct(
        private WorkersSchema $schema,
    ) {
    }

    #[Route('plugin/workers', name: 'plugin.workers', methods: 'GET')]
    public function __invoke(QueryBusInterface $bus, WorkerRequest $request): ResourceInterface
    {
        $workers = $bus->ask(
            new WorkersQuery(
                $request->server,
                $request->plugin,
            ),
        );

        return new WorkerCollection(
            data: $this->schema->create($workers->workers),
            plugin: $request->plugin
        );
    }
}
