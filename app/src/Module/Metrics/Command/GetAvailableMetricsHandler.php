<?php

declare(strict_types=1);

namespace App\Module\Metrics\Command;

use App\Application\Command\Metrics\GetAvailableMetricsQuery;
use App\Infrastructure\VictoriaMetrics\ClientInterface;
use App\Infrastructure\VictoriaMetrics\Payload\Tag;
use Spiral\Cqrs\Attribute\QueryHandler;

final readonly class GetAvailableMetricsHandler
{
    public function __construct(
        private ClientInterface $client,
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
