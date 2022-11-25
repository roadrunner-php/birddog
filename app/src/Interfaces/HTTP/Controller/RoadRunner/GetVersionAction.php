<?php

declare(strict_types=1);

namespace App\Interfaces\HTTP\Controller\RoadRunner;

use App\Application\Command\RoadRunner\GetVersionQuery;
use App\Application\HTTP\Response\JsonResource;
use Spiral\Cqrs\QueryBusInterface;
use Spiral\Router\Annotation\Route;

final class GetVersionAction
{
    #[Route('rr/version', name: 'rr.version.get', methods: 'GET')]
    public function __invoke(QueryBusInterface $bus, GetRequest $request): JsonResource
    {
        return new JsonResource(
            $bus->ask(new GetVersionQuery($request->server))
        );
    }
}
