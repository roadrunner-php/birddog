<?php

declare(strict_types=1);

namespace App\Interfaces\HTTP\Controller\v1\Server;

use App\Application\Command\RoadRunner\GetConfigQuery;
use App\Application\HTTP\Response\JsonResource;
use App\Application\HTTP\Response\ResourceInterface;
use App\Interfaces\HTTP\Filter\v1\RoadRunner\GetRequest;
use Spiral\Cqrs\QueryBusInterface;
use Spiral\Router\Annotation\Route;

final class GetConfigAction
{
    #[Route('server/config', name: 'server.config.get', methods: 'GET')]
    public function __invoke(QueryBusInterface $bus, GetRequest $request): ResourceInterface
    {
        return new JsonResource([
            'data' => $bus->ask(new GetConfigQuery($request->server))->config,
        ]);
    }
}
