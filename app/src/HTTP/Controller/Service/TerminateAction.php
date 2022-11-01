<?php

declare(strict_types=1);

namespace App\HTTP\Controller\Service;

use App\CQRS\Command\Service\TerminateCommand;
use App\HTTP\Request\Service\CommandRequest;
use Spiral\Cqrs\CommandBusInterface;
use Spiral\Router\Annotation\Route;

final class TerminateAction
{
    #[Route('/service/terminate', name: 'api.service.terminate', methods: 'POST')]
    public function __invoke(CommandBusInterface $bus, CommandRequest $request): array
    {
        return [
            'status' => $bus->dispatch(new TerminateCommand($request->server, $request->service)),
        ];
    }
}
