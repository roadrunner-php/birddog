<?php

declare(strict_types=1);

namespace App\Controller\TCP;

use App\CQRS\Command\TCP\CloseCommand;
use App\HTTP\Request\TCP\CloseConnectionRequest;
use Spiral\Cqrs\CommandBusInterface;
use Spiral\Router\Annotation\Route;

final class CloseConnectionAction
{
    #[Route('/tcp/close', name: 'api.tcp.close', methods: 'POST')]
    public function __invoke(CommandBusInterface $bus, CloseConnectionRequest $request): array
    {
        return [
            'status' => $bus->dispatch(new CloseCommand(
                $request->server,
                $request->uuid
            ))
        ];
    }
}
