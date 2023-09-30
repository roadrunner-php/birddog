<?php

declare(strict_types=1);

namespace App\Application\Command\Jobs\DTO;

final readonly class PipelineListResult
{
    public function __construct(
        public string $server,
        public array $pipelines,
    ) {
    }
}
