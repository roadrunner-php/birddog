<?php

declare(strict_types=1);

namespace App\HTTP\Request\Jobs;

use App\HTTP\Request\RulesTrait;
use App\RPC\ServersRegistryInterface;
use Spiral\Filters\Attribute\Input\Query;
use Spiral\Filters\Model\Filter;
use Spiral\Filters\Model\FilterDefinitionInterface;
use Spiral\Filters\Model\HasFilterDefinition;
use Spiral\Validator\FilterDefinition;

final class ListRequest extends Filter implements HasFilterDefinition
{
    use RulesTrait;

    public function __construct(
        private readonly ServersRegistryInterface $registry
    ) {
    }

    #[Query]
    public string $server;

    public function filterDefinition(): FilterDefinitionInterface
    {
        return new FilterDefinition([
            'server' => $this->serverRules($this->registry->getServersNames()),
        ]);
    }
}
