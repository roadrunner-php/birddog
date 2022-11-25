<?php

declare(strict_types=1);

namespace App\Application\Command\Informer;

use Spiral\Cqrs\QueryInterface;

/**
 * Get all plugins with workers.
 */
final class ListQuery implements QueryInterface
{
    public function __construct(
        public readonly string $server,
    ) {
    }
}
