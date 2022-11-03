<?php

declare(strict_types=1);

namespace App\CQRS\Query\Config;

use App\RPC\RPCManagerInterface;
use Spiral\Cqrs\Attribute\QueryHandler;
use Spiral\Goridge\RPC\Codec\JsonCodec;

final class GetHandler
{
    public function __construct(
        private readonly RPCManagerInterface $rpc,
    ) {
    }

    #[QueryHandler]
    public function __invoke(GetQuery $query): array
    {
        $rpc = $this->rpc->getServer($query->server, new JsonCodec());

        $config = $rpc->call('rpc.Config', true);

        return \json_decode(\base64_decode($config), true);
    }
}
