<?php

declare(strict_types=1);

namespace App\Module\RoadRunner\Command;

use App\Application\Command\RoadRunner\DTO\GetVersionResult;
use App\Application\Command\RoadRunner\GetVersionQuery;
use App\Infrastructure\RoadRunner\RPC\RPCManagerInterface;
use Spiral\Cqrs\Attribute\QueryHandler;

final readonly class GetVersionHandler
{
    public function __construct(
        private RPCManagerInterface $rpc,
    ) {
    }

    #[QueryHandler]
    public function __invoke(GetVersionQuery $query): GetVersionResult
    {
        $rpc = $this->rpc->connect($query->server);

        try {
            $version = $rpc->getVersion();
        } catch (\Throwable) {
            $version = '0.0.0';
        }

        return new GetVersionResult(
            server: $query->server,
            version: $version,
        );
    }
}
