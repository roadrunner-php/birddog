<?php

declare(strict_types=1);

namespace App\Interfaces\HTTP\Controller\v1\TCP;

use App\Application\Command\TCP\CloseCommand;
use App\Application\HTTP\Response\ResourceInterface;
use App\Application\HTTP\Response\StatusResource;
use App\Interfaces\HTTP\Filter\v1\TCP\CloseConnectionRequest;
use Spiral\Cqrs\CommandBusInterface;
use Spiral\Router\Annotation\Route;

final class CloseConnectionAction
{
    #[Route('tcp/close', name: 'tcp.close', methods: 'POST')]
    public function __invoke(CommandBusInterface $bus, CloseConnectionRequest $request): ResourceInterface
    {
        return new StatusResource(
            status: $bus->dispatch(
                new CloseCommand(
                    $request->server,
                    $request->uuid,
                ),
            )->status
        );
    }
}
