<?php

declare(strict_types=1);

namespace App\Interfaces\HTTP\Controller\v1\Metrics;

use App\Application\Command\Metrics\GetAvailableMetricsQuery;
use App\Application\HTTP\Response\ResourceInterface;
use App\Interfaces\HTTP\Filter\v1\Metrics\MetricsRequest;
use App\Interfaces\HTTP\Resource\v1\Metrics\MetricResource;
use App\Interfaces\HTTP\Resource\v1\Metrics\MetricsCollection;
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
