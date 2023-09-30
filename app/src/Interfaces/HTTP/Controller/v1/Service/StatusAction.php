<?php

declare(strict_types=1);

namespace App\Interfaces\HTTP\Controller\v1\Service;

use App\Application\Command\Service\StatusQuery;
use App\Application\HTTP\Response\ResourceInterface;
use App\Interfaces\HTTP\Filter\v1\Service\CommandRequest;
use App\Interfaces\HTTP\Resource\v1\Service\StatusCollection;
use Spiral\Cqrs\QueryBusInterface;
use Spiral\Router\Annotation\Route;

final class StatusAction
{
    #[Route('service/status', name: 'service.status', methods: 'GET')]
    public function __invoke(QueryBusInterface $bus, CommandRequest $request): ResourceInterface
    {
        $result = $bus->ask(new StatusQuery($request->server, $request->service));

        return new StatusCollection($result->statuses);
    }
}
