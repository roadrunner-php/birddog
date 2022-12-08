<?php

declare(strict_types=1);

namespace App\Infrastructure\RPC;

use App\Infrastructure\RPC\ValueObject\Server;
use Spiral\Goridge\RPC\Codec\ProtobufCodec;
use Spiral\Goridge\RPC\CodecInterface;
use Spiral\Goridge\RPC\RPC;
use Spiral\Goridge\RPC\RPCInterface;

final class RPCManager implements RPCManagerInterface
{
    public function __construct(
        private readonly ServersRegistryInterface $registry
    ) {
    }

    public function getServer(string $server, ?CodecInterface $codec = null): RPCInterface
    {
        $server = $this->registry->getServer($server) ?? new Server($server, $server);

        return new RPC(
            $server->getRelay(),
            $codec ?? new ProtobufCodec()
        );
    }
}
