<?php

declare(strict_types=1);

namespace App\Application\Command\Metrics;

use Carbon\Carbon;
use Spiral\Cqrs\QueryInterface;

final class GetRangeByKeyQuery implements QueryInterface
{
    public function __construct(
        public readonly string $server,
        public readonly string $key,
        public readonly array $tags = [],
        public readonly \DateTimeInterface $start = new Carbon('-30 minutes'),
        public readonly \DateTimeInterface $end = new Carbon(),
    ) {
    }
}
