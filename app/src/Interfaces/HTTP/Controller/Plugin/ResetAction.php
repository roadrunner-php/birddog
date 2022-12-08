<?php

declare(strict_types=1);

namespace App\Interfaces\HTTP\Controller\Plugin;

use App\Application\Command\Resetter\ResetCommand;
use Spiral\Cqrs\CommandBusInterface;
use Spiral\Router\Annotation\Route;

final class ResetAction
{
    #[Route('plugin/reset', name: 'plugin.reset', methods: 'POST')]
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
