<?php

declare(strict_types=1);

namespace App\Module\Informer\DTO;

final readonly class Worker implements \JsonSerializable, \Stringable
{
    public function __construct(
        public float $cpuPercent,
        public string $command,
        public \DateTimeInterface $createdAt,
        public int $memoryUsage,
        public int $pid,
        public int $numExecs,
        public int $status,
        public string $statusString,
    ) {
    }

    public function __toString(): string
    {
        return \json_encode($this->jsonSerialize());
    }

    public function jsonSerialize(): array
    {
        return [
            'pid' => $this->pid,
            'cpu_percent' => $this->cpuPercent,
            'memory_usage' => $this->memoryUsage,
            'command' => $this->command,
            'num_execs' => $this->numExecs,
            'status' => $this->status,
            'status_string' => $this->statusString,
            'created_at' => $this->createdAt->format(\DateTimeInterface::ATOM),
        ];
    }
}
