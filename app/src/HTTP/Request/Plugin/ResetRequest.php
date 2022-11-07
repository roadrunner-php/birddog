<?php

declare(strict_types=1);

namespace App\HTTP\Request\Plugin;

use App\HTTP\Request\AbstractServerFilter;
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
