<?php

declare(strict_types=1);

namespace App\CQRS\Query\Metrics;

use App\VictoriaMetrics\ClientInterface;
use App\VictoriaMetrics\Payload\Tag;
use Spiral\Cqrs\Attribute\QueryHandler;

final class GetAvailableMetricsHandler
{
    public function __construct(
        private readonly ClientInterface $client,
    ) {
    }

    #[QueryHandler]
    public function handle(GetAvailableMetricsQuery $query): array
    {
        $metrics = $this->client->series(
            tags: [new Tag('server', $query->server)]
        )->jsonSerialize();

        $metrics['server'] = $query->server;

        return $metrics;
    }
}
