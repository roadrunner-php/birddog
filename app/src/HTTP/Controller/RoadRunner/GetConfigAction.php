<?php

declare(strict_types=1);

namespace App\HTTP\Controller\RoadRunner;

use App\CQRS\Query\RoadRunner\GetConfigQuery;
use App\HTTP\Request\Config\GetRequest;
use Spiral\Cqrs\QueryBusInterface;
use Spiral\Router\Annotation\Route;

final class GetConfigAction
{
    #[Route('/rr/config', name: 'api.rr.config.get', methods: 'GET')]
    public function __invoke(QueryBusInterface $bus, GetRequest $request): array
    {
        return [
            'config' => $bus->ask(new GetConfigQuery($request->server))
        ];
    }
}
