<?php

declare(strict_types=1);

namespace App\HTTP\Controller\RoadRunner;

use App\CQRS\Query\RoadRunner\GetVersionQuery;
use App\HTTP\Request\Config\GetRequest;
use Spiral\Cqrs\QueryBusInterface;
use Spiral\Router\Annotation\Route;

final class GetVersionAction
{
    #[Route('/rr/version', name: 'api.rr.version.get', methods: 'GET')]
    public function __invoke(QueryBusInterface $bus, GetRequest $request): array
    {
        return $bus->ask(new GetVersionQuery($request->server));
    }
}
