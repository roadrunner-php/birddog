<?php

declare(strict_types=1);

namespace App\Application\Command\Service\DTO;

final readonly class CreateResult
{
    public function __construct(
        public string $server,
        public bool $status,
    ) {
    }
}
