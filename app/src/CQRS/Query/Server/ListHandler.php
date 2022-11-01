<?php

declare(strict_types=1);

namespace App\CQRS\Query\Server;

use App\RPC\ServersRegistryInterface;
use Spiral\Cqrs\Attribute\QueryHandler;

final class ListHandler
{
    public function __construct(
        private readonly ServersRegistryInterface $registry
    ) {
    }

    #[QueryHandler]
    public function __invoke(ListQuery $query): array
    {
        return [
            'servers' => $this->registry->getServersNames(),
        ];
    }
}
