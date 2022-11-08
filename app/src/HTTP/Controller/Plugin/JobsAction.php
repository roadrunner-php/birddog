<?php

declare(strict_types=1);

namespace App\HTTP\Controller\Plugin;

use App\CQRS\Query\Informer\JobsQuery;
use App\HTTP\Request\Plugin\WorkerRequest;
use Spiral\Cqrs\QueryBusInterface;
use Spiral\Router\Annotation\Route;

final class JobsAction
{
    #[Route('/api/plugin/jobs', name: 'api.plugin.jobs', methods: 'GET')]
    public function __invoke(QueryBusInterface $bus, WorkerRequest $request): array
    {
        return [
            'data' => $bus->ask(new JobsQuery(
                $request->server,
                $request->plugin,
            )),
        ];
    }
}
