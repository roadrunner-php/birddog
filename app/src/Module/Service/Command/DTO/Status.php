<?php

declare(strict_types=1);

namespace App\Module\Service\Command\DTO;

final readonly class Status implements \Stringable, \JsonSerializable
{
    public function __construct(
        public string $command,
        public float $cpuPercent,
        public int $memoryUsage,
        public int $pid,
        public ?string $error = null,
    ) {
    }

    public function __toString(): string
    {
        return \json_encode($this->jsonSerialize(), \JSON_THROW_ON_ERROR);
    }

    public function jsonSerialize(): array
    {
        return [
            'command' => $this->command,
            'cpu_percent' => $this->cpuPercent,
            'memory_usage' => $this->memoryUsage,
            'pid' => $this->pid,
            'error' => $this->error,
        ];
    }
}
