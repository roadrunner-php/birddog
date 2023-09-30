<?php

declare(strict_types=1);

namespace App\Application\Command\Service;

use App\Application\Command\Service\DTO\StatusResult;
use Spiral\Cqrs\QueryInterface;

/**
 * @implements QueryInterface<StatusResult>
 */
final readonly class StatusQuery implements QueryInterface
{
    public function __construct(
        public string $server,
        public string $service,
    ) {
    }
}
