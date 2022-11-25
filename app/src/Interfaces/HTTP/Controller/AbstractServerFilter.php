<?php

declare(strict_types=1);

namespace App\Interfaces\HTTP\Controller;

use App\Infrastructure\RPC\ServersRegistryInterface;
use Spiral\Filters\Attribute\Input\Query;
use Spiral\Filters\Model\Filter;
use Spiral\Filters\Model\FilterDefinitionInterface;
use Spiral\Filters\Model\HasFilterDefinition;
use Spiral\Validator\FilterDefinition;

abstract class AbstractServerFilter extends Filter implements HasFilterDefinition
{
    public function __construct(
        private readonly ServersRegistryInterface $registry
    ) {
    }

    #[Query]
    public string $server;

    protected function getValidationRules(): array
    {
        return [
            'server' => $this->serverRules($this->registry->getServersNames()),
        ];
    }

    public function filterDefinition(): FilterDefinitionInterface
    {
        return new FilterDefinition($this->getValidationRules());
    }

    protected function serverRules(array $serversNames): array
    {
        return ['required', 'string', ['in_array', $serversNames, true, 'error' => 'Invalid service.'],];
    }
}
