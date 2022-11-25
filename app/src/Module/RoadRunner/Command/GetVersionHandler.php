<?php

declare(strict_types=1);

namespace App\Module\RoadRunner\Command;

use App\Application\Command\RoadRunner\GetVersionQuery;
use App\Infrastructure\RPC\RPCManagerInterface;
use Spiral\Cqrs\Attribute\QueryHandler;
use Spiral\Goridge\RPC\Codec\JsonCodec;

final class GetVersionHandler
{
    public function __construct(
        private readonly RPCManagerInterface $rpc,
    ) {
    }

    #[QueryHandler]
    public function __invoke(GetVersionQuery $query): array
    {
        $rpc = $this->rpc->getServer($query->server, new JsonCodec());

        try {
            $version = $rpc->call('rpc.Version', true);
        } catch (\Throwable $e) {
            $version = null;
        }

        return compact('version');
    }
}
