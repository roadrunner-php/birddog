<?php

declare(strict_types=1);

namespace App\Application\Command\Service\DTO;

final readonly class RestartResult
{
    public function __construct(
        public string $server,
        public string $service,
        public bool $status,
    ) {
    }
}
