<?php

declare(strict_types=1);

namespace App\Interfaces\HTTP\Controller\Plugin;

use App\Interfaces\HTTP\Controller\AbstractServerFilter;
use Spiral\Filters\Attribute\Input\Query;

final class WorkerRequest extends AbstractServerFilter
{
    #[Query]
    public string $plugin;

    protected function getValidationRules(): array
    {
        $rules = parent::getValidationRules();
        $rules['plugin'] = ['required', 'string', 'custom:pluginName'];

        return $rules;
    }
}

