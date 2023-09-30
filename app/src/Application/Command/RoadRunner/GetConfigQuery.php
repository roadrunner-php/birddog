<?php

declare(strict_types=1);

namespace App\Application\Command\RoadRunner;

use App\Application\Command\RoadRunner\DTO\GetConfigResult;
use Spiral\Cqrs\QueryInterface;

/**
 * Get config of the RoadRunner server.
 * @implements QueryInterface<GetConfigResult>
 */
final readonly class GetConfigQuery implements QueryInterface
{
    public function __construct(
        public string $server,
    ) {
    }
}
