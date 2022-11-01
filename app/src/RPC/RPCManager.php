<?php

declare(strict_types=1);

namespace App\RPC;

use Spiral\Goridge\RPC\Codec\ProtobufCodec;
use Spiral\Goridge\RPC\CodecInterface;
use Spiral\Goridge\RPC\RPC;
use Spiral\Goridge\RPC\RPCInterface;

final class RPCManager implements RPCManagerInterface
{
    /** @var RPCInterface[] */
    private array $connections = [];

    public function __construct(
        private readonly ServersRegistryInterface $registry
    ) {
    }

    public function getServer(string $server, ?CodecInterface $codec = null): RPCInterface
    {
        $address = $this->registry->getServerAddress($server) ?? $server;

        //if (!isset($this->connections[$address])) {
            $this->connections[$address] = RPC::create($address)->withCodec($codec ?? new ProtobufCodec());
        //}

        $connection = $this->connections[$address];

        if ($codec !== null) {
            return $connection->withCodec($codec);
        }

        return $connection;
    }
}
