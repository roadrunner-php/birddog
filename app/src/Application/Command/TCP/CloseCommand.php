<?php

declare(strict_types=1);

namespace App\Application\Command\TCP;

use App\Application\Command\TCP\DTO\CloseResult;
use Spiral\Cqrs\CommandInterface;

/**
 * @implements CommandInterface<CloseResult>
 */
final readonly class CloseCommand implements CommandInterface
{
    public function __construct(
        public string $server,
        public string $connectionUuid,
    ) {
    }
}
