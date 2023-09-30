<?php

declare(strict_types=1);

namespace App\Module\Metrics\Command;

use App\Application\Command\Metrics\GetByKeyQuery;
use App\Infrastructure\VictoriaMetrics\ClientInterface;
use App\Infrastructure\VictoriaMetrics\Payload\Tag;
use Spiral\Cqrs\Attribute\QueryHandler;

final readonly class GetByKeyHandler
{
    public function __construct(
        private ClientInterface $client
    ) {
    }

    #[QueryHandler]
    public function handle(GetByKeyQuery $query): array
    {
        $tags = $query->tags;
        $id = $query->key;

        if ($tags !== []) {
            $id .= '{' . \implode(',', \array_map(fn(Tag $tag) => $tag->name . '=' . $tag->value, $tags)) . '}';
        }

        $tags[] = new Tag('server', $query->server);

        $point = $this->client->query(
            metric: $query->key,
            step: $query->step,
            tags: $tags,
        );

        return [
            'id' => $id,
            'tags' => $tags,
            'name' => $query->key,
            'server' => $query->server,
            'point' => $point,
        ];
    }
}
