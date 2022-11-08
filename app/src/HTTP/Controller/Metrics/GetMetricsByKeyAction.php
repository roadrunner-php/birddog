<?php

declare(strict_types=1);

namespace App\HTTP\Controller\Metrics;

use App\CQRS\Query\Metrics\GetMetricsByKeyQuery;
use App\HTTP\Request\Metrics\MetricsByKeyRequest;
use App\VictoriaMetrics\Payload\Tag;
use Spiral\Cqrs\QueryBusInterface;
use Spiral\Router\Annotation\Route;

final class GetMetricsByKeyAction
{
    #[Route('/api/metrics/<key>', name: 'api.metrics.by_key', methods: 'GET')]
    public function __invoke(QueryBusInterface $bus, MetricsByKeyRequest $request): array
    {
        $tags = [];
        foreach ($request->tags as $name => $value) {
            $tags[] = new Tag($name, $value);
        }

        return $bus->ask(
            new GetMetricsByKeyQuery(
                $request->server,
                $request->key,
                $tags,
            )
        );
    }
}
