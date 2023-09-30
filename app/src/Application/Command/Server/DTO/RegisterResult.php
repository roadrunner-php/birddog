<?php

declare(strict_types=1);

namespace App\Application\Command\Server\DTO;

final readonly class RegisterResult
{
    public function __construct(
        public bool $status,
    ) {
    }
}
