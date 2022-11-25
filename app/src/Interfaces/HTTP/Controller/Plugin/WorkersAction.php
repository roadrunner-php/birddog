<?php

declare(strict_types=1);

namespace App\Interfaces\HTTP\Controller\Plugin;

use App\Application\Command\Informer\WorkersQuery;
use App\Application\HTTP\Response\ResourceInterface;
use Spiral\Cqrs\QueryBusInterface;
use Spiral\Router\Annotation\Route;

final class WorkersAction
{
    #[Route('plugin/workers', name: 'plugin.workers', methods: 'GET')]
    public function __invoke(
        QueryBusInterface $bus,
        WorkerRequest $request
    ): ResourceInterface {
        return new WorkerCollection(
            $bus->ask(
                new WorkersQuery(
                    $request->server,
                    $request->plugin,
                )
            )
        );
    }
}
