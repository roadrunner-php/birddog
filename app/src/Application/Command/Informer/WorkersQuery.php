<?php

declare(strict_types=1);

namespace App\Application\Command\Informer;

use App\Application\Command\Informer\DTO\WorkersResult;
use Spiral\Cqrs\QueryInterface;

/**
 * Get all workers for plugin.
 * @implements QueryInterface<WorkersResult>
 */
final readonly class WorkersQuery implements QueryInterface
{
    public function __construct(
        public string $server,
        public string $plugin,
    ) {
    }
}
