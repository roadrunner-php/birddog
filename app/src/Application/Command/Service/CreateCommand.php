<?php

declare(strict_types=1);

namespace App\Application\Command\Service;

use App\Application\Command\Service\DTO\CreateResult;
use Spiral\Cqrs\CommandInterface;

/**
 * @implements CommandInterface<CreateResult>
 */
final readonly class CreateCommand implements CommandInterface
{
    public function __construct(
        public string $server,
        public string $name,
        public string $command,
        public int $processNum = 1,
        public int $execTimeout = 0,
        public bool $remainAfterExit = false,
        public array $env = [],
        public int $restartSec = 30
    ) {
    }
}
