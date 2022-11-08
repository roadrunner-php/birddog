<?php

declare(strict_types=1);

namespace App\HTTP\Controller\Plugin;

use App\CQRS\Query\Informer\ListQuery;
use App\HTTP\Request\Plugin\ListRequest;
use Spiral\Cqrs\QueryBusInterface;
use Spiral\Router\Annotation\Route;

final class ListAction
{
    #[Route('/api/plugins', name: 'api.plugin.list', methods: 'GET')]
    public function __invoke(QueryBusInterface $bus, ListRequest $request): array
    {
        return [
            'data' => $bus->ask(new ListQuery($request->server)),
        ];
    }
}
