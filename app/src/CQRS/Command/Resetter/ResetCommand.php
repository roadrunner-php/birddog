<?php

declare(strict_types=1);

namespace App\CQRS\Command\Resetter;

use Spiral\Cqrs\CommandInterface;

final class ResetCommand implements CommandInterface
{
    public function __construct(
        public readonly string $server,
        public readonly string $plugin,
    ) {
    }
}
