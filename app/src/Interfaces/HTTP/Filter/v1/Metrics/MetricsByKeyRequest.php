<?php

declare(strict_types=1);

namespace App\Interfaces\HTTP\Filter\v1\Metrics;

use App\Interfaces\HTTP\Filter\v1\AbstractServerFilter;
use Spiral\Filters\Attribute\Input\Query;
use Spiral\Filters\Attribute\Input\Route;

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
