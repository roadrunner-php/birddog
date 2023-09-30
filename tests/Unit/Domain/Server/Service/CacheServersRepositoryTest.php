<?php

declare(strict_types=1);

namespace Unit\Domain\Server\Service;

use App\Domain\Server\Infrastructure\Cache\ServersRegistry;
use App\Infrastructure\RoadRunner\RPC\ValueObject\Server;
use Psr\SimpleCache\CacheInterface;
use Tests\TestCase;

final class CacheServersRepositoryTest extends TestCase
{
    private CacheInterface|\Mockery\MockInterface $cache;

    protected function setUp(): void
    {
        parent::setUp();

        $this->cache = $this->mockContainer(CacheInterface::class);
    }

    public function testGetDefault(): void
    {
        $repository = new ServersRegistry($this->cache, 'default');

        $this->assertSame('default', $repository->getDefault());
    }

    public function testGetServers(): void
    {
        $repository = new ServersRegistry($this->cache, 'default');

        $this->cache->shouldReceive('get')
            ->once()
            ->with('servers', [])
            ->andReturn([
                'foo' => $foo = [
                    'name' => 'foo',
                    'address' => '127.0.0.2',
                    'has_error' => true,
                ],
                'test' => $test = [
                    'name' => 'test',
                    'address' => '127.0.0.1',
                    'has_error' => false,
                ],
            ]);

        $result = $repository->getServers();

        $this->assertCount(2, $result);

        foreach ($result as $server) {
            $this->assertInstanceOf(Server::class, $server);
        }

        $this->assertSame(\json_encode($foo), \json_encode($result[0]));
        $this->assertSame(\json_encode($test), \json_encode($result[1]));
    }

    public function testGetServerByName(): void
    {
        $repository = new ServersRegistry($this->cache, 'default');

        $this->cache->shouldReceive('get')
            ->times(3)
            ->with('servers', [])
            ->andReturn([
                'foo' => $foo = [
                    'name' => 'foo',
                    'address' => '127.0.0.2',
                    'has_error' => true,
                ],
                'test' => $test = [
                    'name' => 'test',
                    'address' => '127.0.0.1',
                    'has_error' => false,
                ],
            ]);


        $result = $repository->getServer('foo');
        $this->assertSame(\json_encode($foo), \json_encode($result));

        $result = $repository->getServer('test');
        $this->assertSame(\json_encode($test), \json_encode($result));

        $result = $repository->getServer('bar');
        $this->assertNull($result);
    }
}
