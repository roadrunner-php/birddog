<?php

declare(strict_types=1);

namespace App\HTTP\Controller\Server;

use App\CQRS\Query\Server\ListQuery;
use App\RPC\ServersConfig;
use Spiral\Cqrs\QueryBusInterface;
use Spiral\Router\Annotation\Route;

final class ListAction
{
    #[Route('/api/servers', name: 'api.servers.list', methods: 'GET')]
    public function __invoke(QueryBusInterface $bus, ServersConfig $config): array
    {
        return [
            'default' => $config->getDefaultServer(),
            'data' => $bus->ask(new ListQuery()),
        ];
    }
}
