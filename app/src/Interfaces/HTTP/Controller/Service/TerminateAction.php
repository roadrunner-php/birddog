<?php

declare(strict_types=1);

namespace App\Interfaces\HTTP\Controller\Service;

use App\Application\Command\Service\TerminateCommand;
use Spiral\Cqrs\CommandBusInterface;
use Spiral\Router\Annotation\Route;

final class TerminateAction
{
    #[Route('service/terminate', name: 'service.terminate', methods: 'POST')]
    public function __invoke(CommandBusInterface $bus, CommandRequest $request): array
    {
        return [
            'status' => $bus->dispatch(new TerminateCommand($request->server, $request->service)),
        ];
    }
}
