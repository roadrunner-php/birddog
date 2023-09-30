<?php

declare(strict_types=1);

namespace App\Application\Command\Server\DTO;

final readonly class DefaultServerResult
{
    public function __construct(
        public ?string $server,
    ) {
    }
}
