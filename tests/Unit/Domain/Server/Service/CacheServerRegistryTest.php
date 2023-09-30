<?php

declare(strict_types=1);

namespace Unit\Domain\Server\Service;

use App\Application\Config\ServersConfig;
use App\Domain\Server\Infrastructure\Cache\ServersRegistry;
use App\Domain\Server\Service\ServersRegistryInterface;
use Psr\SimpleCache\CacheInterface;
use Tests\TestCase;

final class CacheServerRegistryTest extends TestCase
{
    private CacheInterface|\Mockery\MockInterface $cache;

    protected function setUp(): void
    {
        parent::setUp();

        $this->cache = $this->mockContainer(CacheInterface::class);
    }

    private function getRegistry(array $initialServers = []): ServersRegistryInterface
    {
        return new ServersRegistry($this->cache, 'default', $initialServers);
    }

    public function testAddServerWithPredefinedRecords(): void
    {
        $this->cache->shouldReceive('get')
            ->once()
            ->with('servers', [])
            ->andReturn([]);

        $this->cache->shouldReceive('set')
            ->once()
            ->with('servers', [
                'foo' => [
                    'name' => 'foo',
                    'address' => '127.0.0.2',
                    'has_error' => false,
                ],
            ]);

        $this->cache->shouldReceive('get')
            ->once()
            ->with('servers', [])
            ->andReturn([
                'foo' => [
                    'name' => 'foo',
                    'address' => '127.0.0.2',
                    'has_error' => false,
                ],
            ]);

        $this->cache->shouldReceive('set')
            ->once()
            ->with('servers', [
                'foo' => [
                    'name' => 'foo',
                    'address' => '127.0.0.2',
                    'has_error' => false,
                ],
                'test' => [
                    'name' => 'test',
                    'address' => '127.0.0.1',
                    'has_error' => false,
                ],
            ]);

        $this->getRegistry([
            'foo' => '127.0.0.2',
        ])->addServer(name: 'test', host: '127.0.0.1');
    }

    public function testAddServerToEmptyStorage(): void
    {
        $this->cache->shouldReceive('get')
            ->once()
            ->with('servers', [])
            ->andReturn([]);

        $this->cache->shouldReceive('set')
            ->once()
            ->with('servers', [
                'test' => [
                    'name' => 'test',
                    'address' => '127.0.0.1',
                    'has_error' => false,
                ],
            ]);

        $this->getRegistry()->addServer(name: 'test', host: '127.0.0.1');
    }

    public function testAddServerToStorageWithRecords(): void
    {
        $this->cache->shouldReceive('get')
            ->once()
            ->with('servers', [])
            ->andReturn([
                'foo' => [
                    'name' => 'foo',
                    'address' => '127.0.0.2',
                    'has_error' => true,
                ],
            ]);

        $this->cache->shouldReceive('set')
            ->once()
            ->with('servers', [
                'foo' => [
                    'name' => 'foo',
                    'address' => '127.0.0.2',
                    'has_error' => true,
                ],
                'test' => [
                    'name' => 'test',
                    'address' => '127.0.0.1',
                    'has_error' => false,
                ],
            ]);

        $this->getRegistry()->addServer(name: 'test', host: '127.0.0.1');
    }
}
