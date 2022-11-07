<?php

declare(strict_types=1);

namespace App\HTTP\Request\Jobs;

use App\HTTP\Request\AbstractServerFilter;
use Spiral\Filters\Attribute\Input\Post;

final class CommandRequest extends AbstractServerFilter
{
    #[Post]
    public string $server;

    #[Post]
    public string $pipeline;

    protected function getValidationRules(): array
    {
        $rules = parent::getValidationRules();
        $rules['pipeline'] = ['required', 'string', 'custom:pipelineName'];

        return $rules;
    }
}
