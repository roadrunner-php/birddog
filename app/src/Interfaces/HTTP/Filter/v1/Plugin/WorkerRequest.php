<?php

declare(strict_types=1);

namespace App\Interfaces\HTTP\Filter\v1\Plugin;

use App\Interfaces\HTTP\Filter\v1\AbstractServerFilter;
use Spiral\Filters\Attribute\Input\Data;
use Spiral\Filters\Attribute\Input\Query;

final class WorkerRequest extends AbstractServerFilter
{
    #[Data]
    public string $plugin;

    protected function getValidationRules(): array
    {
        $rules = parent::getValidationRules();
        $rules['plugin'] = ['required', 'string', 'custom:pluginName'];

        return $rules;
    }
}

