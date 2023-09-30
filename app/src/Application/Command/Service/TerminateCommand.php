<?php

declare(strict_types=1);

namespace App\Application\Command\Service;

use App\Application\Command\Service\DTO\TerminateResult;
use Spiral\Cqrs\CommandInterface;

/**
 * @implements CommandInterface<TerminateResult>
 */
final readonly class TerminateCommand implements CommandInterface
{
    public function __construct(
        public string $server,
        public string $service,
    ) {
    }
}
