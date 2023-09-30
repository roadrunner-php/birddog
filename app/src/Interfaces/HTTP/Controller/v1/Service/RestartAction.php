<?php

declare(strict_types=1);

namespace App\Interfaces\HTTP\Controller\v1\Service;

use App\Application\Command\Service\RestartCommand;
use App\Application\HTTP\Response\ResourceInterface;
use App\Application\HTTP\Response\StatusResource;
use App\Interfaces\HTTP\Filter\v1\Service\CommandRequest;
use Spiral\Cqrs\CommandBusInterface;
use Spiral\Router\Annotation\Route;

final class RestartAction
{
    #[Route('service/restart', name: 'service.restart', methods: 'POST')]
    public function __invoke(CommandBusInterface $bus, CommandRequest $request): ResourceInterface
    {
        $result = $bus->dispatch(new RestartCommand($request->server, $request->service));

        return new StatusResource(status: $result->status);
    }
}
