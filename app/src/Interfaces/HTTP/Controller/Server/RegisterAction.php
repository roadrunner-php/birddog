<?php

declare(strict_types=1);

namespace App\Interfaces\HTTP\Controller\Server;

use App\Application\Command\Server\RegisterCommand;
use Spiral\Cqrs\CommandBusInterface;
use Spiral\Router\Annotation\Route;

final class RegisterAction
{
    #[Route('server/register', name: 'server.register', methods: 'POST')]
    public function __invoke(CommandBusInterface $bus, RegisterRequest $request): array
    {
        $bus->dispatch(
            new RegisterCommand(
                name: $request->name,
                address: $request->address
            )
        );

        return [
            'status' => true,
        ];
    }
}
