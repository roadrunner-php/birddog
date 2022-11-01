<?php

declare(strict_types=1);

namespace App\HTTP\Controller\Service;

use App\CQRS\Command\Service\RestartCommand;
use App\HTTP\Request\Service\CommandRequest;
use Spiral\Cqrs\CommandBusInterface;
use Spiral\Router\Annotation\Route;

final class RestartAction
{
    #[Route('/service/restart', name: 'api.service.restart', methods: 'POST')]
    public function __invoke(CommandBusInterface $bus, CommandRequest $request): array
    {
        return [
            'status' => $bus->dispatch(new RestartCommand($request->server, $request->service)),
        ];
    }
}
