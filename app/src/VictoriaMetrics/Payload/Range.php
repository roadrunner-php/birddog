<?php

declare(strict_types=1);

namespace App\VictoriaMetrics\Payload;

final class Range implements \JsonSerializable
{
    /**
     * @param Value[] $values
     */
    public function __construct(
        public readonly array $values,
        public readonly \DateTimeInterface $start,
        public readonly \DateTimeInterface $end,
    ) {
    }

    public function jsonSerialize(): array
    {
        return [
            'values' => $this->values,
            'start' => $this->start->getTimestamp(),
            'end' => $this->end->getTimestamp(),
        ];
    }
}
