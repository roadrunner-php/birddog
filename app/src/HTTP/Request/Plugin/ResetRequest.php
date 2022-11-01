<?php

declare(strict_types=1);

namespace App\HTTP\Request\Plugin;

use App\HTTP\Request\RulesTrait;
use App\RPC\ServersRegistryInterface;
use Spiral\Filters\Attribute\Input\Post;
use Spiral\Filters\Model\Filter;
use Spiral\Filters\Model\FilterDefinitionInterface;
use Spiral\Filters\Model\HasFilterDefinition;
use Spiral\Validator\FilterDefinition;

final class ResetRequest extends Filter implements HasFilterDefinition
{
    use RulesTrait;

    public function __construct(
        private readonly ServersRegistryInterface $registry
    ) {
    }

    #[Post]
    public string $server;

    #[Post]
    public string $plugin;

    public function filterDefinition(): FilterDefinitionInterface
    {
        return new FilterDefinition([
            'server' => $this->serverRules($this->registry->getServersNames()),
            'plugin' => ['required', 'string'],
        ]);
    }
}
