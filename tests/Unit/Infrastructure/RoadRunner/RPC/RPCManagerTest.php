<?php

declare(strict_types=1);

namespace Unit\Infrastructure\RoadRunner\RPC;

use App\Domain\Server\Service\ServersRepositoryInterface;
use App\Infrastructure\RoadRunner\RPC\RPCClient;
use App\Infrastructure\RoadRunner\RPC\RPCManager;
use App\Infrastructure\RoadRunner\RPC\ValueObject\Server;
use Tests\TestCase;

final class RPCManagerTest extends TestCase
{
    private ServersRepositoryInterface|\Mockery\MockInterface $servers;

    protected function setUp(): void
    {
        parent::setUp();

        $this->servers = $this->mockContainer(ServersRepositoryInterface::class);
    }

    public function testGetServerByName(): void
    {
        $manager = new RPCManager($this->servers);

        $this->servers->shouldReceive('getServer')
            ->once()
            ->with('foo')
            ->andReturn(new Server('foo', 'tcp://127.0.0.1:6001'));

        $client = $manager->connect('foo');

        $this->assertInstanceOf(RPCClient::class, $client);
        $this->assertSame('foo', $client->server->name);
        $this->assertSame('tcp://127.0.0.1:6001', (string) $client->server->address);
    }

    public function testGetServerByHost(): void
    {
        $manager = new RPCManager($this->servers);

        $this->servers->shouldReceive('getServer')
            ->once()
            ->with('tcp://127.0.0.1:6002')
            ->andReturnNull();

        $client = $manager->connect('tcp://127.0.0.1:6002');

        $this->assertInstanceOf(RPCClient::class, $client);

        $this->assertSame('tcp://127.0.0.1:6002', $client->server->name);
        $this->assertSame('tcp://127.0.0.1:6002', (string) $client->server->address);
    }
}
