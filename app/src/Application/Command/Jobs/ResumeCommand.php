<?php

declare(strict_types=1);

namespace App\Application\Command\Jobs;

use App\Application\Command\Jobs\DTO\ResumeResult;
use Spiral\Cqrs\CommandInterface;

/**
 * Resume a paused pipeline.
 * @implements CommandInterface<ResumeResult>
 */
final readonly class ResumeCommand implements CommandInterface
{
    public function __construct(
        public string $server,
        public string $pipeline,
    ) {
    }
}
