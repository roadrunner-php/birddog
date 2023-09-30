<?php

declare(strict_types=1);

namespace App\Module\Server\Command;

use App\Application\Command\Server\DTO\ListResult;
use App\Application\Command\Server\ListQuery;
use App\Domain\Server\Service\ServersRepositoryInterface;
use Spiral\Cqrs\Attribute\QueryHandler;

final readonly class ListServersHandler
{
    public function __construct(
        private ServersRepositoryInterface $servers,
    ) {
    }

    #[QueryHandler]
    public function __invoke(ListQuery $query): ListResult
    {
        return new ListResult(
            servers: $this->servers->getServers(),
        );
    }
}
