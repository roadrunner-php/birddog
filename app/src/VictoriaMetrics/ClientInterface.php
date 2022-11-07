<?php

declare(strict_types=1);

namespace App\VictoriaMetrics;

use Carbon\Carbon;

interface ClientInterface
{
    public function put(PointInterface ...$point): void;

    public function queryRange(
        string $metric,
        float $step,
        \DateTimeInterface $start,
        \DateTimeInterface $end,
        array $tags = [],
    ): Range;
}
