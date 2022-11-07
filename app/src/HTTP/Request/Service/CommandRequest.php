<?php

declare(strict_types=1);

namespace App\HTTP\Request\Service;

use App\HTTP\Request\AbstractServerFilter;
use Spiral\Filters\Attribute\Input\Input;

final class CommandRequest extends AbstractServerFilter
{
    #[Input]
    public string $server;

    #[Input]
    public string $service;

    protected function getValidationRules(): array
    {
        $rules = parent::getValidationRules();
        $rules['service'] = ['required', 'string', 'custom:serviceName'];

        return $rules;
    }
}
