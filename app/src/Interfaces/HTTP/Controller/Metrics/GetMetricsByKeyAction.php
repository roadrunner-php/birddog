<?php

declare(strict_types=1);

namespace App\Interfaces\HTTP\Controller\Metrics;

use App\Application\Command\Metrics\GetMetricsByKeyQuery;
use App\Infrastructure\VictoriaMetrics\Payload\Tag;
use Spiral\Cqrs\QueryBusInterface;
use Spiral\Router\Annotation\Route;

final class GetMetricsByKeyAction
{
    #[Route('metrics/<key>', name: 'metrics.by_key', methods: 'GET')]
    public function __invoke(QueryBusInterface $bus, MetricsByKeyRequest $request): array
    {
        $tags = [];
        foreach ($request->tags as $name => $value) {
            $tags[] = new Tag($name, $value);
        }

        return [
            'data' => $bus->ask(
                new GetMetricsByKeyQuery(
                    $request->server,
                    $request->key,
                    $tags,
                )
            )
        ];
    }
}
