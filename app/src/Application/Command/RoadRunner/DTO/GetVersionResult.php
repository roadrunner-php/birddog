<?php

declare(strict_types=1);

namespace App\Application\Command\RoadRunner\DTO;

final readonly class GetVersionResult
{
    public function __construct(
        public string $server,
        public string $version,
    ) {
    }
}
