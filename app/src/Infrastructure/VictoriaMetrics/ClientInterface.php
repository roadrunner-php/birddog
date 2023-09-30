<?php

declare(strict_types=1);

namespace App\Infrastructure\VictoriaMetrics;

use App\Infrastructure\VictoriaMetrics\Payload\Point;
use App\Infrastructure\VictoriaMetrics\Payload\Range;
use App\Infrastructure\VictoriaMetrics\Payload\Series;
use App\Infrastructure\VictoriaMetrics\Payload\Tag;
use Carbon\Carbon;

interface ClientInterface
{
    public function put(PointInterface ...$point): void;


    /**
     * Evaluates an expression query over last value.
     *
     * @param non-empty-string $metric
     * @param Tag[] $tags
     * @return Point[]
     */
    public function query(
        string $metric,
        ?string $step = null,
        array $tags = [],
    ): array;

    /**
     * Evaluates an expression query over a range of time.
     *
     * @param non-empty-string $metric
     * @param Tag[] $tags
     */
    public function queryRange(
        string $metric,
        float $step = 5,
        \DateTimeInterface $start = new Carbon('-30 minutes'),
        \DateTimeInterface $end = new Carbon(),
        array $tags = [],
    ): Range;

    /**
     * Returns the list of time series that match a certain label set.
     *
     * @param Tag[] $tags
     */
    public function series(
        array $tags,
        \DateTimeInterface $start = new Carbon('-5 minutes'),
        \DateTimeInterface $end = new Carbon(),
    ): Series;
}
