<?php

declare(strict_types=1);

namespace App\CQRS\Query\Service;

use App\RPC\RPCManagerInterface;
use Spiral\Cqrs\Attribute\QueryHandler;
use Spiral\RoadRunner\Services\Manager;

final class ListHandler
{
    public function __construct(
        private readonly RPCManagerInterface $rpc,
    ) {
    }

    #[QueryHandler]
    public function __invoke(ListQuery $query): array
    {
        $manager = new Manager($this->rpc->getServer($query->server));

        return [
            'services' => $manager->list(),
        ];
    }
}
