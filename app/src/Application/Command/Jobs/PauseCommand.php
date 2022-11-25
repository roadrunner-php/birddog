<?php

declare(strict_types=1);

namespace App\Application\Command\Jobs;

use Spiral\Cqrs\CommandInterface;

final class PauseCommand implements CommandInterface
{
    public function __construct(
        public readonly string $server,
        public readonly string $pipeline,
    ) {
    }
}
