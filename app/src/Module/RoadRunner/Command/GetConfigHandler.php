<?php

declare(strict_types=1);

namespace App\Module\RoadRunner\Command;

use App\Application\Command\RoadRunner\GetConfigQuery;
use App\Infrastructure\RPC\RPCManagerInterface;
use Spiral\Cqrs\Attribute\QueryHandler;
use Spiral\Goridge\RPC\Codec\JsonCodec;

final class GetConfigHandler
{
    public function __construct(
        private readonly RPCManagerInterface $rpc,
    ) {
    }

    #[QueryHandler]
    public function __invoke(GetConfigQuery $query): array
    {
        $rpc = $this->rpc->getServer($query->server, new JsonCodec());

        try {
            $config = $rpc->call('rpc.Config', true);

            return \json_decode(\base64_decode($config), true);
        } catch (\Throwable $e) {
            return [];
        }
    }
}
