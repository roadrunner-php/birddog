<?php

declare(strict_types=1);

namespace App\Interfaces\HTTP\Controller\TCP;

use App\Interfaces\HTTP\Controller\AbstractServerFilter;
use Spiral\Filters\Attribute\Input\Post;

final class CloseConnectionRequest extends AbstractServerFilter
{
    #[Post]
    public string $server;

    #[Post]
    public string $uuid;

    protected function getValidationRules(): array
    {
        $rules = parent::getValidationRules();
        $rules['uuid'] = [
            'required',
            'string',
            'custom:uuid',
        ];

        return $rules;
    }
}
