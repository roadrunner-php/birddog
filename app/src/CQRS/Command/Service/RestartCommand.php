<?php

declare(strict_types=1);

namespace App\CQRS\Command\Service;

use Spiral\Cqrs\CommandInterface;

final class RestartCommand implements CommandInterface
{
    public function __construct(
        public readonly string $server,
        public readonly string $service,
    ) {
    }
}
