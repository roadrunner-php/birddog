<?php

declare(strict_types=1);

namespace App\CQRS\Query\Config;

use Spiral\Cqrs\QueryInterface;

final class GetQuery implements QueryInterface
{
    public function __construct(
        public readonly string $server,
    ) {
    }
}
