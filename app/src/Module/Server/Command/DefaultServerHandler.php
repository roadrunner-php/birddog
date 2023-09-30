<?php

declare(strict_types=1);

namespace App\Module\Server\Command;

use App\Application\Command\Server\DefaultServerQuery;
use App\Application\Command\Server\DTO\DefaultServerResult;
use App\Domain\Server\Service\ServersRepositoryInterface;
use Spiral\Cqrs\Attribute\QueryHandler;

final readonly class DefaultServerHandler
{
    public function __construct(
        private ServersRepositoryInterface $servers,
    ) {
    }

    #[QueryHandler]
    public function __invoke(DefaultServerQuery $query): DefaultServerResult
    {
        return new DefaultServerResult(
            server: $this->servers->getDefault(),
        );
    }
}
