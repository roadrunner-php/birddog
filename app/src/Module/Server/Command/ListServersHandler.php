<?php

declare(strict_types=1);

namespace App\Module\Server\Command;

use App\Application\Command\Server\ListQuery;
use App\Infrastructure\RPC\ServersRegistryInterface;
use Spiral\Cqrs\Attribute\QueryHandler;

final class ListServersHandler
{
    public function __construct(
        private readonly ServersRegistryInterface $registry
    ) {
    }

    #[QueryHandler]
    public function __invoke(ListQuery $query): array
    {
        return [
            'servers' => $this->registry->getServers(),
        ];
    }
}
