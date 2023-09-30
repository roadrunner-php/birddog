<?php

declare(strict_types=1);

namespace App\Application\Command\RoadRunner\DTO;

final readonly class GetConfigResult
{
    public function __construct(
        public string $server,
        public array $config,
    ) {
    }
}
