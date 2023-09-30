<?php

declare(strict_types=1);

namespace App\Interfaces\HTTP\Controller\v1\Settings;

use App\Application\Command\Settings\StoreCommand;
use App\Application\HTTP\Response\ResourceInterface;
use App\Application\HTTP\Response\StatusResource;
use App\Interfaces\HTTP\Filter\v1\Settings\StoreRequest;
use Spiral\Cqrs\CommandBusInterface;
use Spiral\Router\Annotation\Route;

final class StoreAction
{
    #[Route('settings', name: 'settings.store', methods: 'POST')]
    public function __invoke(CommandBusInterface $bus, StoreRequest $request): ResourceInterface
    {
        $result = $bus->dispatch(new StoreCommand($request->settings));

        return new StatusResource(status: $result->status);
    }
}
