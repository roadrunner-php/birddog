<?php

declare(strict_types=1);

namespace App\Interfaces\HTTP\Filter\v1\Jobs;

use App\Interfaces\HTTP\Filter\v1\AbstractServerFilter;
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
