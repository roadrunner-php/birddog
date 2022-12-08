<?php

declare(strict_types=1);

namespace App\Infrastructure\VictoriaMetrics\Payload;

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
            'name' => $this->name,
            'type' => $this->type,
            'tags' => $this->tags,
        ];
    }
}
