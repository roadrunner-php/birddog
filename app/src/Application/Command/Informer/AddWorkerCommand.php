<?php

declare(strict_types=1);

namespace App\Application\Command\Informer;

use App\Application\Command\Informer\DTO\AddWorkerResult;
use Spiral\Cqrs\CommandInterface;

/**
 * Add worker to plugin.
 * @implements CommandInterface<AddWorkerResult>
 */
final readonly class AddWorkerCommand implements CommandInterface
{
    public function __construct(
        public string $server,
        public string $plugin,
    ) {
    }
}
