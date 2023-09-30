<?php

declare(strict_types=1);

namespace App\Interfaces\HTTP\Controller\v1\Plugin\Worker;

use App\Application\Command\Informer\AddWorkerCommand;
use App\Application\HTTP\Response\ResourceInterface;
use App\Application\HTTP\Response\StatusResource;
use App\Interfaces\HTTP\Filter\v1\Informer\WorkerManagerRequest;
use Spiral\Cqrs\CommandBusInterface;
use Spiral\Router\Annotation\Route;

final class AddAction
{
    #[Route('plugin/worker', name: 'plugin.worker.add', methods: 'POST')]
    public function __invoke(CommandBusInterface $bus, WorkerManagerRequest $request): ResourceInterface
    {
        $result = $bus->dispatch(new AddWorkerCommand($request->server, $request->plugin));

        return new StatusResource(status: $result->status);
    }
}
