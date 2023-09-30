<?php

declare(strict_types=1);

namespace App\Application\Command\Resetter;

use App\Application\Command\Resetter\DTO\ResetResult;
use Spiral\Cqrs\CommandInterface;

/**
 * @implements CommandInterface<ResetResult>
 */
final readonly class ResetCommand implements CommandInterface
{
    public function __construct(
        public string $server,
        public string $plugin,
    ) {
    }
}
