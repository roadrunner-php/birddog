<?php

declare(strict_types=1);

namespace App\VictoriaMetrics;

interface PointInterface extends \JsonSerializable
{
    /**
     * Get the metric name.
     */
    public function getMetric(): string;

    /**
     * Get the metric value.
     */
    public function getValue(): float|int|string;

    /**
     * Get the metric tags.
     * @return array<non-empty-string, non-empty-string>
     */
    public function getTags(): array;
}
