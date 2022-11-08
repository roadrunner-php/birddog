<?php

declare(strict_types=1);

namespace App\VictoriaMetrics\Payload;

final class Metric implements \JsonSerializable
{
    public function __construct(
        public readonly string $name,
        public readonly string $type,
        public readonly array $tags,
    ) {
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => \sprintf(
                '%s{%s}',
                $this->name,
                \implode(',', \array_map(fn(Tag $tag) => $tag->name . '=' . $tag->value, $this->tags)),
            ),
            'name' => $this->name,
            'type' => $this->type,
            'tags' => $this->tags,
        ];
    }
}
