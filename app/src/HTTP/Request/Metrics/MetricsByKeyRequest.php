<?php

declare(strict_types=1);

namespace App\HTTP\Request\Metrics;

use App\HTTP\Request\AbstractServerFilter;
use App\VictoriaMetrics\Payload\Tag;
use Spiral\Filters\Attribute\Input\Query;
use Spiral\Filters\Attribute\Input\Route;
use Spiral\Filters\Attribute\NestedArray;

final class MetricsByKeyRequest extends AbstractServerFilter
{
    #[Route]
    public string $key;

    #[Query(key: 'tag')]
    public array $tags = [];

    protected function getValidationRules(): array
    {
        $rules = parent::getValidationRules();
        $rules['key'] = ['required', 'string', 'custom:metricsKey'];
        $rules['tags'] = ['array', 'custom:tags'];

        return $rules;
    }
}
