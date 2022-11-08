<?php

declare(strict_types=1);

namespace App\VictoriaMetrics;

use App\VictoriaMetrics\Payload\Range;
use App\VictoriaMetrics\Payload\Series;
use App\VictoriaMetrics\Payload\Tag;
use Carbon\Carbon;

interface ClientInterface
{
    public function put(PointInterface ...$point): void;

    /**
     * Evaluates an expression query over a range of time.
     *
     * @param non-empty-string $metric
     * @param Tag[] $tags
     */
    public function queryRange(
        string $metric,
        float $step,
        \DateTimeInterface $start,
        \DateTimeInterface $end,
        array $tags = [],
    ): Range;

    /**
     * Returns the list of time series that match a certain label set.
     *
     * @param Tag[] $tags
     */
    public function series(
        array $tags,
        \DateTimeInterface $start = new Carbon('-30 minutes'),
        \DateTimeInterface $end = new Carbon(),
    ): Series;
}
