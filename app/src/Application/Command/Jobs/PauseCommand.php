<?php

declare(strict_types=1);

namespace App\Application\Command\Jobs;

use App\Application\Command\Jobs\DTO\PauseResult;
use Spiral\Cqrs\CommandInterface;

/**
 * Pause a running pipeline.
 * @implements CommandInterface<PauseResult>
 */
final readonly class PauseCommand implements CommandInterface
{
    public function __construct(
        public string $server,
        public string $pipeline,
    ) {
    }
}
