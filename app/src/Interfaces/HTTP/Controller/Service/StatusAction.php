<?php

declare(strict_types=1);

namespace App\Interfaces\HTTP\Controller\Service;

use App\Application\Command\Service\StatusQuery;
use Spiral\Cqrs\QueryBusInterface;
use Spiral\Router\Annotation\Route;

final class StatusAction
{
    #[Route('service/status', name: 'service.status', methods: 'GET')]
    public function __invoke(QueryBusInterface $bus, CommandRequest $request): array
    {
        return [
            'data' => $bus->ask(new StatusQuery($request->server, $request->service)),
        ];
    }
}
