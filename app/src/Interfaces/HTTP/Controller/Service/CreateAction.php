<?php

declare(strict_types=1);

namespace App\Interfaces\HTTP\Controller\Service;

use App\Application\Command\Service\CreateCommand;
use Spiral\Cqrs\CommandBusInterface;
use Spiral\Router\Annotation\Route;

final class CreateAction
{
    #[Route('service/create', name: 'service.create', methods: 'POST')]
    public function __invoke(CommandBusInterface $bus, CreateRequest $request): array
    {
        return [
            'status' => $bus->dispatch(
                new CreateCommand(
                    server: $request->server,
                    name: $request->name,
                    command: $request->command,
                    processNum: $request->processNum,
                    execTimeout: $request->execTimeout,
                    remainAfterExit: $request->remainAfterExit,
                    env: $request->env,
                    restartSec: $request->restartSec
                )
            ),
        ];
    }
}
