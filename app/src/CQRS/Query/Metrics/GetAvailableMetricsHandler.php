<?php

declare(strict_types=1);

namespace App\CQRS\Query\Metrics;

use Carbon\Carbon;
use Spiral\Cache\CacheStorageProviderInterface;
use Spiral\Cqrs\Attribute\QueryHandler;
use Spiral\Cqrs\QueryBusInterface;

final class GetAvailableMetricsHandler
{
    public function __construct(
        private readonly QueryBusInterface $queryBus,
        private readonly CacheStorageProviderInterface $cache,
        private readonly int $ttlInMinutes = 10
    ) {
    }

    #[QueryHandler]
    public function handle(GetAvailableMetricsQuery $query): array
    {
        $cache = $this->cache->storage('metrics');
        $cacheKey = 'metrics:keys:' . $query->server;

        if ($cache->has($cacheKey)) {
            $keys = $cache->get($cacheKey);
        } else {
            $metrics = $this->queryBus->ask(new GetMetricsQuery($query->server));
            $keys = [];
            foreach ($metrics as $key => $metric) {
                $keys[$key] = [
                    'name' => $key,
                    'description' => $metric->description,
                    'type' => $metric->type,
                ];
            }

            $cache->set(
                $cacheKey,
                $keys,
                Carbon::now()->addMinutes($this->ttlInMinutes)->diffAsCarbonInterval()
            );
        }

        return $keys;
    }
}
