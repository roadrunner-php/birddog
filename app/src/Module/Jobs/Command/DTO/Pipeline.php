<?php

declare(strict_types=1);

namespace App\Module\Jobs\Command\DTO;

final readonly class Pipeline implements \Stringable, \JsonSerializable
{
    public function __construct(
        public string $pipeline,
        public string $driver,
        public string $queue,
        public int $priority,
        public int $active,
        public int $delayed,
        public int $reserved,
        public bool $ready,
    ) {
    }

    public function __toString(): string
    {
        return \json_encode($this, \JSON_THROW_ON_ERROR);
    }

    public function jsonSerialize(): array
    {
        return [
            'pipeline' => $this->pipeline,
            'driver' => $this->driver,
            'queue' => $this->queue,
            'priority' => $this->priority,
            'active' => $this->active,
            'delayed' => $this->delayed,
            'reserved' => $this->reserved,
            'ready' => $this->ready,
        ];
    }
}
