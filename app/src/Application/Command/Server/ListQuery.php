<?php

declare(strict_types=1);

namespace App\Application\Command\Server;

use App\Application\Command\Server\DTO\ListResult;
use Spiral\Cqrs\QueryInterface;

/**
 * Get all available servers.
 *
 * @implements QueryInterface<ListResult>
 */
final class ListQuery implements QueryInterface
{
}
