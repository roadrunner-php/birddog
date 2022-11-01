<?php

declare(strict_types=1);

namespace App\HTTP\Request\TCP;

use App\HTTP\Request\RulesTrait;
use App\RPC\ServersRegistryInterface;
use Spiral\Filters\Attribute\Input\Post;
use Spiral\Filters\Model\Filter;
use Spiral\Filters\Model\FilterDefinitionInterface;
use Spiral\Filters\Model\HasFilterDefinition;
use Spiral\Validator\FilterDefinition;

final class CloseConnectionRequest extends Filter implements HasFilterDefinition
{
    use RulesTrait;

    public function __construct(
        private readonly ServersRegistryInterface $registry
    ) {
    }

    #[Post]
    public string $server;

    #[Post]
    public string $uuid;

    public function filterDefinition(): FilterDefinitionInterface
    {
        return new FilterDefinition([
            'server' => $this->serverRules($this->registry->getServersNames()),
            'uuid' => ['required', 'string', ['regexp', '/\w{8}-\w{4}-\w{4}-\w{4}-\w{12}/', 'error' => 'Invalid uuid.']]
        ]);
    }
}
