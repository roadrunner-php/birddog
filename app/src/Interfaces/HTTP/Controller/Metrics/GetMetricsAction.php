<?php

declare(strict_types=1);

namespace App\Interfaces\HTTP\Controller\Metrics;

use App\Application\Command\Metrics\GetAvailableMetricsQuery;
use Spiral\Cqrs\QueryBusInterface;
use Spiral\Router\Annotation\Route;

final class GetMetricsAction
{
    #[Route('metrics', name: 'metrics.list', methods: 'GET')]
    public function __invoke(QueryBusInterface $bus, MetricsRequest $request): array
    {
        return [
            'data' => $bus->ask(
                new GetAvailableMetricsQuery(
                    $request->server
                )
            ),
        ];
    }
}
