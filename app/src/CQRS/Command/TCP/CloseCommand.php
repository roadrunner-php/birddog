<?php

declare(strict_types=1);

namespace App\CQRS\Command\TCP;

use Spiral\Cqrs\CommandInterface;

final class CloseCommand implements CommandInterface
{
    public function __construct(
        public readonly string $server,
        public readonly string $connectionUuid,
    ) {
    }
}
