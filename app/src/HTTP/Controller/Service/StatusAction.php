<?php

declare(strict_types=1);

namespace App\HTTP\Controller\Service;

use App\CQRS\Query\Service\StatusQuery;
use App\HTTP\Request\Service\CommandRequest;
use Spiral\Cqrs\QueryBusInterface;
use Spiral\Router\Annotation\Route;

final class StatusAction
{
    #[Route('/api/service/status', name: 'api.service.status', methods: 'GET')]
    public function __invoke(QueryBusInterface $bus, CommandRequest $request): array
    {
        return [
            'data' => $bus->ask(new StatusQuery($request->server, $request->service)),
        ];
    }
}
