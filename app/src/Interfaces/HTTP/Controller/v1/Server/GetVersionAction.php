<?php

declare(strict_types=1);

namespace App\Interfaces\HTTP\Controller\v1\Server;

use App\Application\Command\RoadRunner\GetVersionQuery;
use App\Application\HTTP\Response\JsonResource;
use App\Application\HTTP\Response\ResourceInterface;
use App\Interfaces\HTTP\Filter\v1\RoadRunner\GetRequest;
use Spiral\Cqrs\QueryBusInterface;
use Spiral\Router\Annotation\Route;

final class GetVersionAction
{
    #[Route('server/version', name: 'server.version.get', methods: 'GET')]
    public function __invoke(QueryBusInterface $bus, GetRequest $request): ResourceInterface
    {
        return new JsonResource([
            'data' => [
                'version' => $bus->ask(new GetVersionQuery($request->server))->version,
            ],
        ]);
    }
}
