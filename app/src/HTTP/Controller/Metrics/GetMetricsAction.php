<?php

declare(strict_types=1);

namespace App\HTTP\Controller\Metrics;

use App\CQRS\Query\Metrics\GetAvailableMetricsQuery;
use App\HTTP\Request\Metrics\MetricsRequest;
use Spiral\Cqrs\QueryBusInterface;
use Spiral\Router\Annotation\Route;

final class GetMetricsAction
{
    #[Route('/metrics', name: 'api.metrics.list', methods: 'GET')]
    public function __invoke(QueryBusInterface $bus, MetricsRequest $request): array
    {
        return [
            'data' => \array_values($bus->ask(new GetAvailableMetricsQuery($request->server))),
        ];
    }
}
