<?php

declare(strict_types=1);

namespace App\Interfaces\HTTP\Controller\Plugin;

use App\Application\Command\Informer\ListQuery;
use App\Application\HTTP\Response\ResourceInterface;
use Spiral\Cqrs\QueryBusInterface;
use Spiral\Router\Annotation\Route;

final class ListAction
{
    #[Route('plugins', name: 'plugin.list', methods: 'GET')]
    public function __invoke(
        QueryBusInterface $bus,
        ListRequest $request
    ): ResourceInterface {
        return new PluginCollection(
            $bus->ask(new ListQuery($request->server))
        );
    }
}
