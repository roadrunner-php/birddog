<?php

declare(strict_types=1);

namespace App\HTTP\Request\Metrics;

use App\HTTP\Request\AbstractServerFilter;
use Spiral\Filters\Attribute\Input\Route;

final class MetricsByKeyRequest extends AbstractServerFilter
{
    #[Route]
    public string $key;

    protected function getValidationRules(): array
    {
        $rules = parent::getValidationRules();
        $rules['key'] = ['required', 'string', 'custom:metricsKey'];

        return $rules;
    }
}
