<?php

declare(strict_types=1);

namespace App\Application\Command\Informer;

use App\Application\Command\Informer\DTO\RemoveWorkerResult;
use Spiral\Cqrs\CommandInterface;

/**
 * Remove worker from plugin.
 * @implements CommandInterface<RemoveWorkerResult>
 */
final readonly class RemoveWorkerCommand implements CommandInterface
{
    public function __construct(
        public string $server,
        public string $plugin,
    ) {
    }
}
