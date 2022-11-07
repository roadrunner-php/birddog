<?php

declare(strict_types=1);

namespace App\VictoriaMetrics;

final class Value implements \JsonSerializable
{
    public function __construct(
        public readonly \DateTimeInterface $time,
        public readonly int|float|string $value,
    ) {
    }

    public function jsonSerialize(): array
    {
        return [$this->time->getTimestamp(), $this->value];
    }
}
