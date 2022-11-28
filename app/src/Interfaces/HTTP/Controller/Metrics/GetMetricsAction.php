<?php

declare(strict_types=1);

namespace App\Interfaces\HTTP\Controller\Metrics;

use App\Application\Command\Metrics\GetAvailableMetricsQuery;
use App\Application\HTTP\Response\ResourceInterface;
use Spiral\Cqrs\QueryBusInterface;
use Spiral\Router\Annotation\Route;

final class GetMetricsAction
{
    #[Route('metrics', name: 'metrics.list', methods: 'GET')]
    public function __invoke(QueryBusInterface $bus, MetricsRequest $request): ResourceInterface
    {
        return new MetricsCollection(
            $bus->ask(
                new GetAvailableMetricsQuery(
                    $request->server
                )
            ),
            MetricResource::class,
        );
    }
}
