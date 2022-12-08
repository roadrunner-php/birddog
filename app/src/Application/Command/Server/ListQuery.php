<?php

declare(strict_types=1);

namespace App\Application\Command\Server;

use Spiral\Cqrs\QueryInterface;

/**
 * Get all available servers.
 */
final class ListQuery implements QueryInterface
{
}
