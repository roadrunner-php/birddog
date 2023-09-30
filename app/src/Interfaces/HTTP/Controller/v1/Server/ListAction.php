<?php

declare(strict_types=1);

namespace App\Interfaces\HTTP\Controller\v1\Server;

use App\Application\Command\Server\DefaultServerQuery;
use App\Application\Command\Server\ListQuery;
use App\Application\HTTP\Response\ResourceInterface;
use App\Interfaces\HTTP\Resource\v1\Server\ServerCollection;
use Spiral\Cqrs\QueryBusInterface;
use Spiral\Router\Annotation\Route;

final class ListAction
{
    #[Route('servers', name: 'servers.list', methods: 'GET')]
    public function __invoke(QueryBusInterface $bus): ResourceInterface
    {
        $result = $bus->ask(new ListQuery());
        $default = $bus->ask(new DefaultServerQuery());

        return new ServerCollection(
            servers: $result->servers,
            default: $default->server,
        );
    }
}
