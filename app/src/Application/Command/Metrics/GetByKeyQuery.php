<?php

declare(strict_types=1);

namespace App\Application\Command\Metrics;

use Spiral\Cqrs\QueryInterface;

final readonly class GetByKeyQuery implements QueryInterface
{
    public function __construct(
        public string $server,
        public string $key,
        public array $tags = [],
        public ?string $step = '1m'
    ) {
    }
}
