<?php

declare(strict_types=1);

namespace App\Application\Command\Informer;

use Spiral\Cqrs\QueryInterface;

final class JobsQuery implements QueryInterface
{
    public function __construct(
        public readonly string $server,
        public readonly string $plugin,
    ) {
    }
}
