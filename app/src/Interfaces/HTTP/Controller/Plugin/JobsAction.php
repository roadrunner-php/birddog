<?php

declare(strict_types=1);

namespace App\Interfaces\HTTP\Controller\Plugin;

use App\Application\Command\Informer\JobsQuery;
use Spiral\Cqrs\QueryBusInterface;
use Spiral\Router\Annotation\Route;

final class JobsAction
{
    #[Route('plugin/jobs', name: 'plugin.jobs', methods: 'GET')]
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
