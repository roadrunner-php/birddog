<?php

declare(strict_types=1);

namespace App\HTTP\Controller\Plugin;

use App\CQRS\Command\Resetter\ResetCommand;
use App\HTTP\Request\Plugin\ResetRequest;
use Spiral\Cqrs\CommandBusInterface;
use Spiral\Router\Annotation\Route;

final class ResetAction
{
    #[Route('/plugin/reset', name: 'api.plugin.reset', methods: 'POST')]
    public function __invoke(CommandBusInterface $bus, ResetRequest $request): array
    {
        return [
            'status' => $bus->dispatch(new ResetCommand(
                $request->server,
                $request->plugin,
            )),
        ];
    }
}
