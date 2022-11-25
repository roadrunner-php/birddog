<?php

declare(strict_types=1);

namespace App\Application\Command\Metrics;

use Spiral\Cqrs\QueryInterface;

final class GetMetricsByKeyQuery implements QueryInterface
{
    public function __construct(
        public readonly string $server,
        public readonly string $key,
        public readonly array $tags = [],
    ) {
    }
}
