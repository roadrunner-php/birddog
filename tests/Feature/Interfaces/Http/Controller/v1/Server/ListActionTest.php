<?php

declare(strict_types=1);

namespace Tests\Feature\Interfaces\Http\Controller\v1\Server;

use App\Infrastructure\RoadRunner\RPC\ValueObject\Server;
use Tests\Feature\Interfaces\Http\Controller\ControllerTestCase;

final class ListActionTest extends ControllerTestCase
{
    public function testListServers(): void
    {
        $this->servers
            ->shouldReceive('getServers')
            ->once()
            ->andReturn([
                new Server(name: 'foo', address: 'tcp://127.0.0.2'),
                new Server(name: 'bar', address: 'tcp://127.0.0.1'),
            ]);

        $this->servers
            ->shouldReceive('getDefault')
            ->once()
            ->andReturn('bar');

        $this->http
            ->listServers()
            ->assertJsonResponseSame([
                'data' => [
                    [
                        'name' => 'foo',
                        'address' => 'tcp://127.0.0.2',
                        'has_error' => false,
                    ],
                    [
                        'name' => 'bar',
                        'address' => 'tcp://127.0.0.1',
                        'has_error' => false,
                    ],
                ],
                'meta' => [
                    'grid' => [],
                ],
                'default' => 'bar',
            ]);
    }
}
