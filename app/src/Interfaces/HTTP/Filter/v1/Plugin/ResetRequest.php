<?php

declare(strict_types=1);

namespace App\Interfaces\HTTP\Filter\v1\Plugin;

use App\Interfaces\HTTP\Filter\v1\AbstractServerFilter;
use Spiral\Filters\Attribute\Input\Post;

final class ResetRequest extends AbstractServerFilter
{
    #[Post]
    public string $server;

    #[Post]
    public string $plugin;

    protected function getValidationRules(): array
    {
        $rules = parent::getValidationRules();
        $rules['plugin'] = ['required', 'string', 'custom:pluginName'];

        return $rules;
    }
}
