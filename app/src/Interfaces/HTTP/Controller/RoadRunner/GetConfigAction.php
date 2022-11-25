<?php

declare(strict_types=1);

namespace App\Interfaces\HTTP\Controller\RoadRunner;

use App\Application\Command\RoadRunner\GetConfigQuery;
use Spiral\Cqrs\QueryBusInterface;
use Spiral\Router\Annotation\Route;

final class GetConfigAction
{
    #[Route('rr/config', name: 'rr.config.get', methods: 'GET')]
    public function __invoke(QueryBusInterface $bus, GetRequest $request): array
    {
        return [
            'config' => $bus->ask(new GetConfigQuery($request->server))
        ];
    }
}
