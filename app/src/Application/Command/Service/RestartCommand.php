<?php

declare(strict_types=1);

namespace App\Application\Command\Service;

use App\Application\Command\Service\DTO\RestartResult;
use Spiral\Cqrs\CommandInterface;

/**
 * @implements CommandInterface<RestartResult>
 */
final readonly class RestartCommand implements CommandInterface
{
    public function __construct(
        public string $server,
        public string $service,
    ) {
    }
}
