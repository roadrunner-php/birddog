<?php

declare(strict_types=1);

namespace App\Interfaces\HTTP\Controller\v1\Metrics;

use App\Application\Command\Metrics\GetRangeByKeyQuery;
use App\Infrastructure\VictoriaMetrics\Payload\Tag;
use App\Interfaces\HTTP\Filter\v1\Metrics\MetricsByKeyRequest;
use Spiral\Cqrs\QueryBusInterface;
use Spiral\Router\Annotation\Route;

final class GetRangeByKeyAction
{
    #[Route('metrics/<key>/range', name: 'metrics.range.by_key', methods: 'GET')]
    public function __invoke(QueryBusInterface $bus, MetricsByKeyRequest $request): array
    {
        $tags = [];
        foreach ($request->tags as $name => $value) {
            $tags[] = new Tag($name, $value);
        }

        return [
            'data' => $bus->ask(
                new GetRangeByKeyQuery(
                    $request->server,
                    $request->key,
                    $tags,
                )
            )
        ];
    }
}
