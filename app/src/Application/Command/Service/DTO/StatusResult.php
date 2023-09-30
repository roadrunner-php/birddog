<?php

declare(strict_types=1);

namespace App\Application\Command\Service\DTO;

use App\Module\Service\Command\DTO\Status;

final readonly class StatusResult
{
    /**
     * @param Status[] $statuses
     */
    public function __construct(
        public string $server,
        public string $service,
        public array $statuses,
    ) {
    }
}
