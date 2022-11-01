<?php

declare(strict_types=1);

namespace App\HTTP\Controller\Service;

use App\CQRS\Query\Service\ListQuery;
use App\HTTP\Request\Service\ListRequest;
use Spiral\Cqrs\QueryBusInterface;
use Spiral\Router\Annotation\Route;

final class ListAction
{
    #[Route('/services', name: 'api.service.list', methods: 'GET')]
    public function __invoke(QueryBusInterface $bus, ListRequest $request): array
    {
        return [
            'data' => $bus->ask(new ListQuery($request->server)),
        ];
    }
}
