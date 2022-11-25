<?php

declare(strict_types=1);

namespace App\Interfaces\HTTP\Controller\Server;

use App\Application\Command\Server\ListQuery;
use App\Infrastructure\RPC\ServersConfig;
use Spiral\Cqrs\QueryBusInterface;
use Spiral\Router\Annotation\Route;

final class ListAction
{
    #[Route('servers', name: 'servers.list', methods: 'GET')]
    public function __invoke(QueryBusInterface $bus, ServersConfig $config): array
    {
        return [
            'default' => $config->getDefaultServer(),
            'data' => $bus->ask(new ListQuery()),
        ];
    }
}
