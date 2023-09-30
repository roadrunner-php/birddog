<?php

declare(strict_types=1);

namespace App\Interfaces\HTTP\Filter\v1;

use App\Domain\Server\Service\ServersRepositoryInterface;
use App\Infrastructure\RoadRunner\RPC\ValueObject\Server;
use Spiral\Filters\Attribute\Input\Data;
use Spiral\Filters\Attribute\Input\Query;
use Spiral\Filters\Model\Filter;
use Spiral\Filters\Model\FilterDefinitionInterface;
use Spiral\Filters\Model\HasFilterDefinition;
use Spiral\Validator\FilterDefinition;

abstract class AbstractServerFilter extends Filter implements HasFilterDefinition
{
    #[Data]
    public string $server;

    public function __construct(
        private readonly ServersRepositoryInterface $servers,
    ) {
    }

    protected function getValidationRules(): array
    {
        return [
            'server' => $this->serverRules(
                \array_map(
                    fn(Server $server): string => $server->name,
                    $this->servers->getServers(),
                ),
            ),
        ];
    }

    public function filterDefinition(): FilterDefinitionInterface
    {
        return new FilterDefinition($this->getValidationRules());
    }

    protected function serverRules(array $serversNames): array
    {
        return ['required', 'string', ['in_array', $serversNames, true, 'error' => 'Server is not registered.'],];
    }
}
