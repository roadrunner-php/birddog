<?php

declare(strict_types=1);

namespace Tests\Feature\Interfaces\Http\Controller\v1\Server;

use Tests\Feature\Interfaces\Http\Controller\ControllerTestCase;

final class GetConfigActionTest extends ControllerTestCase
{
    public function testGetConfig(): void
    {
        $this->rpc
            ->withRegisteredServers('foo')
            ->shouldConnect('foo')
            ->assertCall('rpc.Config', true)
            ->andReturnConfig($config = [
                'foo' => 'bar',
                'server' => [
                    'rpc' => 'tpc://127.0.0.1'
                ]
            ]);

        $this->http
            ->getConfig(server: 'foo')
            ->assertJsonResponseSame([
                'data' => $config
            ]);
    }

    public function testServerShouldBeRegistered(): void
    {
        $this->rpc->withRegisteredServers('bar');

        $this->http
            ->getConfig(server: 'foo')
            ->assertValidationErrors([
                'server' => 'Server is not registered.',
            ]);
    }

    public function testServerIsRequired(): void
    {
        $this->rpc->withRegisteredServers('foo');

        $this->http
            ->getConfig(server: null)
            ->assertValidationErrors([
                'server' => 'This value is required.',
            ]);
    }
}
