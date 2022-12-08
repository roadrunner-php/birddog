<?php

declare(strict_types=1);

namespace App\Interfaces\HTTP\Controller\Server;

use Spiral\Filters\Attribute\Input\Post;
use Spiral\Filters\Model\Filter;
use Spiral\Filters\Model\FilterDefinitionInterface;
use Spiral\Filters\Model\HasFilterDefinition;
use Spiral\Validator\FilterDefinition;

final class RegisterRequest extends Filter implements HasFilterDefinition
{
    #[Post]
    public string $name;

    #[Post]
    public string $address;

    public function filterDefinition(): FilterDefinitionInterface
    {
        return new FilterDefinition([
            'name' => ['required', 'string', 'custom:serverName'],
            'address' => ['required', 'string', 'custom:tcpAddress'],
        ]);
    }
}
