<?php

declare(strict_types=1);

namespace App\Interfaces\HTTP\Controller\TCP;

use App\Application\Command\TCP\CloseCommand;
use Spiral\Cqrs\CommandBusInterface;
use Spiral\Router\Annotation\Route;

final class CloseConnectionAction
{
    #[Route('tcp/close', name: 'tcp.close', methods: 'POST')]
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
