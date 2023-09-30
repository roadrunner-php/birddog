<?php

declare(strict_types=1);

namespace App\Infrastructure\RoadRunner\RPC;

use App\Domain\Server\Service\ServersRepositoryInterface;
use App\Infrastructure\RoadRunner\RPC\ValueObject\Server;
use Spiral\Goridge\RPC\Codec\ProtobufCodec;
use Spiral\Goridge\RPC\CodecInterface;
use Spiral\Goridge\RPC\RPC;
use Spiral\Goridge\RPC\RPCInterface;

final readonly class RPCManager implements RPCManagerInterface
{
    public function __construct(
        private ServersRepositoryInterface $servers,
    ) {
    }

    public function connect(string $server): RPCClient
    {
        $server = $this->servers->getServer($server) ?? new Server($server, $server);

        return new RPCClient(
            rpc: new RPC($server->getRelay()),
            server: $server,
        );
    }
}
