<?php

declare(strict_types=1);

namespace App\Domain\Server\Collector;

interface DataCollectorRepositoryInterface
{
    /**
     * Get all collectors.
     *
     * @return array<CollectorInterface>
     */
    public function get(): array;
}
