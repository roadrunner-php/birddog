<?php

declare(strict_types=1);

namespace App\Application\Command\Metrics;

use Carbon\Carbon;
use Spiral\Cqrs\QueryInterface;

final readonly class GetRangeByKeyQuery implements QueryInterface
{
    public function __construct(
        public string $server,
        public string $key,
        public array $tags = [],
        public \DateTimeInterface $start = new Carbon('-30 minutes'),
        public \DateTimeInterface $end = new Carbon(),
    ) {
    }
}
