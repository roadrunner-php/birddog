<?php

declare(strict_types=1);

namespace App\Application\Command\Metrics;

use Carbon\Carbon;
use Spiral\Cqrs\QueryInterface;

final class GetAvailableMetricsQuery implements QueryInterface
{
    public function __construct(
        public readonly string $server
    ) {
    }
}
