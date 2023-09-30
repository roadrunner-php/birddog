<?php

declare(strict_types=1);

namespace App\Application\Command\Jobs;

use App\Application\Command\Jobs\DTO\PipelineListResult;
use Spiral\Cqrs\QueryInterface;

/**
 * Get all created jobs plugin pipelines.
 * @implements QueryInterface<PipelineListResult>
 */
final readonly class PipelineListQuery implements QueryInterface
{
    public function __construct(
        public string $server
    ) {
    }
}
