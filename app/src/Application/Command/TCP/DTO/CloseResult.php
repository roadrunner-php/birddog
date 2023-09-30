<?php

declare(strict_types=1);

namespace App\Application\Command\TCP\DTO;

final readonly class CloseResult
{
    public function __construct(
        public string $server,
        public string $connectionUuid,
        public bool $status,
    ) {
    }
}
