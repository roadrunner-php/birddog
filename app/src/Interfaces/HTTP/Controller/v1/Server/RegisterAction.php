<?php

declare(strict_types=1);

namespace App\Interfaces\HTTP\Controller\v1\Server;

use App\Application\Command\Server\RegisterCommand;
use App\Application\HTTP\Response\ResourceInterface;
use App\Application\HTTP\Response\StatusResource;
use App\Interfaces\HTTP\Filter\v1\Server\RegisterRequest;
use Spiral\Cqrs\CommandBusInterface;
use Spiral\Router\Annotation\Route;

final class RegisterAction
{
    #[Route('server', name: 'server.register', methods: 'POST')]
    public function __invoke(CommandBusInterface $bus, RegisterRequest $request): ResourceInterface
    {
        $result = $bus->dispatch(
            new RegisterCommand(
                name: $request->name,
                address: $request->address,
            ),
        );

        return new StatusResource(status: $result->status);
    }
}
