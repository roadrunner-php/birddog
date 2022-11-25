<?php

declare(strict_types=1);

namespace App\Interfaces\HTTP\Controller\Service;

use App\Application\Command\Service\ListQuery;
use Spiral\Cqrs\QueryBusInterface;
use Spiral\Router\Annotation\Route;

final class ListAction
{
    #[Route('services', name: 'service.list', methods: 'GET')]
    public function __invoke(QueryBusInterface $bus, ListRequest $request): array
    {
        return [
            'data' => $bus->ask(new ListQuery($request->server)),
        ];
    }
}
