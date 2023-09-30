<?php

declare(strict_types=1);

namespace App\Application\Command\Informer\DTO;

final readonly class AddWorkerResult
{
    public function __construct(
        public string $server,
        public string $plugin,
        public bool $status,
    ) {
    }
}
