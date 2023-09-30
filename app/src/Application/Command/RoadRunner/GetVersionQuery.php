<?php

declare(strict_types=1);

namespace App\Application\Command\RoadRunner;

use App\Application\Command\RoadRunner\DTO\GetVersionResult;
use Spiral\Cqrs\QueryInterface;

/**
 * Get version of the RoadRunner server.
 * @implements QueryInterface<GetVersionResult>
 */
final readonly class GetVersionQuery implements QueryInterface
{
    public function __construct(
        public string $server,
    ) {
    }
}
