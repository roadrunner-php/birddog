<?php

declare(strict_types=1);

namespace App\VictoriaMetrics\Payload;

final class Series implements \JsonSerializable
{
    /**
     * @param Metric[] $metrics
     */
    public function __construct(
        public readonly array $metrics,
        public readonly \DateTimeInterface $start,
        public readonly \DateTimeInterface $end,
    ) {
    }

    public function jsonSerialize(): array
    {
        return [
            'metrics' => $this->metrics,
            'start' => $this->start->getTimestamp(),
            'end' => $this->end->getTimestamp(),
        ];
    }
}
