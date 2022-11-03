<?php

declare(strict_types=1);

namespace App\HTTP\Controller\Config;

use App\CQRS\Query\Config\GetQuery;
use App\HTTP\Request\Config\GetRequest;
use Spiral\Cqrs\QueryBusInterface;
use Spiral\Router\Annotation\Route;

final class GetAction
{
    #[Route('/config', name: 'api.config.get', methods: 'GET')]
    public function __invoke(QueryBusInterface $bus, GetRequest $request): array
    {
        return $bus->ask(new GetQuery($request->server));
    }
}
