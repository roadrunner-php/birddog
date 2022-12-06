<?php

declare(strict_types=1);

namespace App\Interfaces\HTTP\Controller\Settings;

use Spiral\Filters\Attribute\Input\Post;
use Spiral\Filters\Model\Filter;
use Spiral\Filters\Model\FilterDefinitionInterface;
use Spiral\Filters\Model\HasFilterDefinition;
use Spiral\Validator\FilterDefinition;

final class StoreRequest extends Filter implements HasFilterDefinition
{
    #[Post]
    public array $settings = [];

    public function filterDefinition(): FilterDefinitionInterface
    {
        return new FilterDefinition([
            'settings' => ['required', 'array'],
        ]);
    }
}
