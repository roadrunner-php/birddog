<?php

declare(strict_types=1);

namespace App\Controller\Plugin;

use App\CQRS\Query\Informer\WorkersQuery;
use App\HTTP\Request\Plugin\WorkerRequest;
use Spiral\Cqrs\QueryBusInterface;
use Spiral\Router\Annotation\Route;

final class WorkersAction
{
    #[Route('/plugin/workers', name: 'api.plugin.workers', methods: 'GET')]
    public function __invoke(QueryBusInterface $bus, WorkerRequest $request): array
    {
        return [
            'data' => $bus->ask(new WorkersQuery(
                $request->server,
                $request->plugin,
            )),
        ];
    }
}
