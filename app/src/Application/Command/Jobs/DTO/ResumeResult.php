<?php

declare(strict_types=1);

namespace App\Application\Command\Jobs\DTO;

final class ResumeResult
{
    public function __construct(
        public string $server,
        public string $pipeline,
        public bool $status,
    ) {
    }
}
