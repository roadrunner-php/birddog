<?php

declare(strict_types=1);

namespace App\Application\Command\Informer;

use App\Application\Command\Informer\DTO\PluginListResult;
use Spiral\Cqrs\QueryInterface;

/**
 * Get all plugins with workers.
 * @implements QueryInterface<PluginListResult>
 */
final readonly class PluginListQuery implements QueryInterface
{
    public function __construct(
        public string $server,
    ) {
    }
}
