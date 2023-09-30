<?php

declare(strict_types=1);

namespace Tests\App\RPC;

use App\Domain\Server\Service\ServersRepositoryInterface;
use App\Infrastructure\RoadRunner\RPC\RPCClient;
use App\Infrastructure\RoadRunner\RPC\ValueObject\Server;
use Spiral\Goridge\RPC\RPCInterface;

final class RPCManagerFaker
{
    public function __construct(
        private \Mockery\MockInterface $manager,
        private ServersRepositoryInterface|\Mockery\MockInterface $servers,
    ) {
    }

    public function withRegisteredServers(string ...$name): self
    {
        $this->servers->shouldReceive('getServers')->andReturn(
            \array_map(
                fn(string $name) => new Server($name, 'tcp://127.0.0.1'),
                $name,
            ),
        );

        return $this;
    }

    public function shouldConnect(string $name, int $times = 1): RPCFaker
    {
        $client = \Mockery::mock(RPCInterface::class);
        $rpc = new RPCFaker($client);

        $client->shouldReceive('withCodec')->andReturnSelf();

        $this->servers->shouldReceive('getServer')
            ->with($name)
            ->andReturn($server = new Server($name, 'tcp://127.0.0.1'));

        $this->manager->shouldReceive('connect')
            ->times($times)
            ->with($name)
            ->andReturn(new RPCClient($client, $server));

        return $rpc;
    }
}
