<?php

declare(strict_types=1);

namespace App\Interfaces\HTTP\Controller\Settings;

use App\Application\Command\Settings\StoreCommand;
use Spiral\Cqrs\CommandBusInterface;
use Spiral\Router\Annotation\Route;

final class StoreAction
{
    #[Route('settings', name: 'settings.store', methods: 'POST')]
    public function __invoke(CommandBusInterface $bus, StoreRequest $request): array
    {
        $bus->dispatch(new StoreCommand($request->settings));

        return [
            'status' => true,
        ];
    }
}
