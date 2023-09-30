<?php

declare(strict_types=1);

namespace App\Application\Command\Server\DTO;

use App\Infrastructure\RoadRunner\RPC\ValueObject\Server;

final readonly class ListResult
{
    /**
     * @param Server[] $servers
     */
    public function __construct(
        public array $servers,
    ) {
    }
}
