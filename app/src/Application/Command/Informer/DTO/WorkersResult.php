<?php

declare(strict_types=1);

namespace App\Application\Command\Informer\DTO;

use App\Module\Informer\DTO\Worker;

final readonly class WorkersResult
{
    /**
     * @param Worker[] $workers
     */
    public function __construct(
        public string $server,
        public string $plugin,
        public array $workers,
    ) {
    }
}
