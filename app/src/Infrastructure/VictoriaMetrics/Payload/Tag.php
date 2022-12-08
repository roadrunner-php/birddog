<?php

declare(strict_types=1);

namespace App\Infrastructure\VictoriaMetrics\Payload;

final class Tag implements \JsonSerializable
{
    public function __construct(
        public readonly string $name,
        public readonly string $value,
    ) {
    }

    public function jsonSerialize(): array
    {
        return [
            'name' => $this->name,
            'value' => $this->value,
        ];
    }
}
