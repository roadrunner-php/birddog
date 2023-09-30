<?php

declare(strict_types=1);

namespace App\Application\Command\Metrics;

use Spiral\Cqrs\QueryInterface;

final readonly class GetAvailableMetricsQuery implements QueryInterface
{
    public function __construct(
        public string $server
    ) {
    }
}
