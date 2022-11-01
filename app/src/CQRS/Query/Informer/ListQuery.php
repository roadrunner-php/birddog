<?php

declare(strict_types=1);

namespace App\CQRS\Query\Informer;

use Spiral\Cqrs\QueryInterface;

final class ListQuery implements QueryInterface
{
    public function __construct(
        public readonly string $server,
    ) {
    }
}
