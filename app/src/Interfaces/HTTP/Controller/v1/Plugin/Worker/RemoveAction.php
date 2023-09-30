<?php

declare(strict_types=1);

namespace App\Interfaces\HTTP\Controller\v1\Plugin\Worker;

use App\Application\Command\Informer\RemoveWorkerCommand;
use App\Application\HTTP\Response\ResourceInterface;
use App\Application\HTTP\Response\StatusResource;
use App\Interfaces\HTTP\Filter\v1\Informer\WorkerManagerRequest;
use Spiral\Cqrs\CommandBusInterface;
use Spiral\Router\Annotation\Route;

final class RemoveAction
{
    #[Route('plugin/worker', name: 'plugin.worker.remove', methods: 'DELETE')]
    public function __invoke(CommandBusInterface $bus, WorkerManagerRequest $request): ResourceInterface
    {
        $result = $bus->dispatch(new RemoveWorkerCommand($request->server, $request->plugin));

        return new StatusResource(status: $result->status);
    }
}
