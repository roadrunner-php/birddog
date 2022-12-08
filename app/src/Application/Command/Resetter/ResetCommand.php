<?php

declare(strict_types=1);

namespace App\Application\Command\Resetter;

use Spiral\Cqrs\CommandInterface;

final class ResetCommand implements CommandInterface
{
    public function __construct(
        public readonly string $server,
        public readonly string $plugin,
    ) {
    }
}
