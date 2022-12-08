<?php

declare(strict_types=1);

namespace App\Module\Metrics\Command;

use App\Application\Command\Metrics\GetRangeByKeyQuery;
use App\Infrastructure\VictoriaMetrics\ClientInterface;
use App\Infrastructure\VictoriaMetrics\Payload\Tag;
use Spiral\Cqrs\Attribute\QueryHandler;

final class GetRangeByKeyHandler
{
    public function __construct(
        private readonly ClientInterface $client
    ) {
    }

    #[QueryHandler]
    public function handle(GetRangeByKeyQuery $query): array
    {
        $tags = $query->tags;

        $id = $query->key;

        if ($tags !== []) {
            $id .= '{' . \implode(',', \array_map(fn(Tag $tag) => $tag->name . '=' . $tag->value, $tags)) . '}';
        }

        $tags[] = new Tag('server', $query->server);

        $range = $this->client->queryRange(
            metric: $query->key,
            start: $query->start,
            end: $query->end,
            tags: $tags,
        );

        return [
            'id' => $id,
            'tags' => $tags,
            'name' => $query->key,
            'server' => $query->server,
            'range' => $range,
        ];
    }
}
