<?php

declare(strict_types=1);

namespace App\HTTP\Controller\Metrics;

use App\CQRS\Query\Metrics\GetMetricsByKeyQuery;
use App\HTTP\Request\Metrics\MetricsByKeyRequest;
use Spiral\Cqrs\QueryBusInterface;
use Spiral\Router\Annotation\Route;

final class GetMetricsByKeyAction
{
    #[Route('/metrics/<key>', name: 'api.metrics.by_key', methods: 'GET')]
    public function __invoke(QueryBusInterface $bus, MetricsByKeyRequest $request): array
    {
        return $bus->ask(new GetMetricsByKeyQuery($request->server, $request->key));
    }
}
