<?php

declare(strict_types=1);

namespace App\Interfaces\HTTP\Controller\Service;

use App\Application\Command\Service\RestartCommand;
use Spiral\Cqrs\CommandBusInterface;
use Spiral\Router\Annotation\Route;

final class RestartAction
{
    #[Route('service/restart', name: 'service.restart', methods: 'POST')]
    public function __invoke(CommandBusInterface $bus, CommandRequest $request): array
    {
        return [
            'status' => $bus->dispatch(new RestartCommand($request->server, $request->service)),
        ];
    }
}
