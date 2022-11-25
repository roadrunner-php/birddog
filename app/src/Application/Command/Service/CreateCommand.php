<?php

declare(strict_types=1);

namespace App\Application\Command\Service;

use Spiral\Cqrs\CommandInterface;

final class CreateCommand implements CommandInterface
{
    public function __construct(
        public readonly string $server,
        public readonly string $name,
        public readonly string $command,
        public readonly int $processNum = 1,
        public readonly int $execTimeout = 0,
        public readonly bool $remainAfterExit = false,
        public readonly array $env = [],
        public readonly int $restartSec = 30
    ) {
    }
}
