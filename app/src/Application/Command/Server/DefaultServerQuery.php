<?php

declare(strict_types=1);

namespace App\Application\Command\Server;

use App\Application\Command\Server\DTO\DefaultServerResult;
use Spiral\Cqrs\QueryInterface;

/**
 * Get all available servers.
 *
 * @implements QueryInterface<DefaultServerResult>
 */
final class DefaultServerQuery implements QueryInterface
{
}
