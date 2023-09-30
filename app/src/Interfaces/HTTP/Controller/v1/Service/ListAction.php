<?php

declare(strict_types=1);

namespace App\Interfaces\HTTP\Controller\v1\Service;

use App\Application\Command\Service\ListQuery;
use App\Application\HTTP\Response\JsonResource;
use App\Application\HTTP\Response\ResourceInterface;
use App\Interfaces\HTTP\Filter\v1\Service\ListRequest;
use Spiral\Cqrs\QueryBusInterface;
use Spiral\Router\Annotation\Route;

final class ListAction
{
    #[Route('services', name: 'service.list', methods: 'GET')]
    public function __invoke(QueryBusInterface $bus, ListRequest $request): ResourceInterface
    {
        return new JsonResource([
            'data' => $bus->ask(new ListQuery($request->server))->services,
        ]);
    }
}
