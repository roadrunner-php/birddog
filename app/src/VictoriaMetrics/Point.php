<?php

declare(strict_types=1);

namespace App\VictoriaMetrics;

class Point implements PointInterface
{
    private array $tags = [];

    public function __construct(
        private readonly string $metric,
        private readonly float|int|string $value,
        array $tags = [],
    ) {
        foreach ($tags as $tag) {
            $this->addTag($tag);
        }
    }

    public function addTag(Tag $tag): void
    {
        $this->tags[$tag->name] = $tag->value;
    }

    public function getMetric(): string
    {
        return $this->metric;
    }

    public function getValue(): float|int|string
    {
        return $this->value;
    }

    public function getTags(): array
    {
        return $this->tags;
    }

    public function jsonSerialize(): array
    {
        return [
            'metric' => $this->metric,
            'value' => $this->value,
            'tags' => $this->tags,
        ];
    }
}
