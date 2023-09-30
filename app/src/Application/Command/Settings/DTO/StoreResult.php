<?php

declare(strict_types=1);

namespace App\Application\Command\Settings\DTO;

final readonly class StoreResult
{
    public function __construct(
        public bool $status,
    ) {
    }
}
