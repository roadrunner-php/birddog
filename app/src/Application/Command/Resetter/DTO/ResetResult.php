<?php

declare(strict_types=1);

namespace App\Application\Command\Resetter\DTO;

final readonly class ResetResult
{
    public function __construct(
        public string $server,
        public string $plugin,
        public bool $status,
    ) {
    }
}
