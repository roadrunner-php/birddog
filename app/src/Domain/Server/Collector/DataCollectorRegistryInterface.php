<?php

declare(strict_types=1);

namespace App\Domain\Server\Collector;

interface DataCollectorRegistryInterface
{
    /**
     * Register a collector.
     */
    public function register(CollectorInterface $collector): void;
}
