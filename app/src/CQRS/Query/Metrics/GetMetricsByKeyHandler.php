<?php

declare(strict_types=1);

namespace App\CQRS\Query\Metrics;

use App\VictoriaMetrics\ClientInterface;
use App\VictoriaMetrics\Tag;
use Spiral\Cqrs\Attribute\QueryHandler;
use Spiral\Cqrs\QueryBusInterface;

final class GetMetricsByKeyHandler
{
    public function __construct(
        private readonly QueryBusInterface $queryBus,
        private readonly ClientInterface $client
    ) {
    }

    #[QueryHandler]
    public function handle(GetMetricsByKeyQuery $query): array
    {
        $keys = $this->queryBus->ask(new GetAvailableMetricsQuery($query->server));


        $range = $this->client->queryRange(
            metric: $query->key,
            tags: [
                new Tag('server', $query->server),
            ]
        );

        return [
            'metric' => $keys[$query->key],
            'range' => $range,
        ];
    }
}
