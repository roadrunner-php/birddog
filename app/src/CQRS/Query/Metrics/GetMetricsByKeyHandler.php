<?php

declare(strict_types=1);

namespace App\CQRS\Query\Metrics;

use App\VictoriaMetrics\ClientInterface;
use App\VictoriaMetrics\Payload\Tag;
use Spiral\Cqrs\Attribute\QueryHandler;

final class GetMetricsByKeyHandler
{
    public function __construct(
        private readonly ClientInterface $client
    ) {
    }

    #[QueryHandler]
    public function handle(GetMetricsByKeyQuery $query): array
    {
        $tags = $query->tags;
        $tags[] = new Tag('server', $query->server);

        $range = $this->client->queryRange(
            metric: $query->key,
            tags: $tags
        );

        return [
            'tags' => $tags,
            'name' => $query->key,
            'server' => $query->server,
            'range' => $range,
        ];
    }
}
