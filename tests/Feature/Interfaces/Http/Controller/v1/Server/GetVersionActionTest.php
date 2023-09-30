<?php

declare(strict_types=1);

namespace Tests\Feature\Interfaces\Http\Controller\v1\Server;

use Tests\Feature\Interfaces\Http\Controller\ControllerTestCase;

final class GetVersionActionTest extends ControllerTestCase
{
    public function testGetVersion(): void
    {
        $this->rpc
            ->withRegisteredServers('foo')
            ->shouldConnect('foo')
            ->assertCall('rpc.Version', true)
            ->andReturnVersion($version = '1.0.0');

        $this->http
            ->getVersion(server: 'foo')
            ->assertJsonResponseSame([
                'data' => [
                    'version' => $version,
                ]
            ]);
    }

    public function testServerShouldBeRegistered(): void
    {
        $this->rpc->withRegisteredServers('bar');

        $this->http
            ->getVersion(server: 'foo')
            ->assertValidationErrors([
                'server' => 'Server is not registered.',
            ]);
    }

    public function testServerIsRequired(): void
    {
        $this->rpc->withRegisteredServers('foo');

        $this->http
            ->getVersion(server: null)
            ->assertValidationErrors([
                'server' => 'This value is required.',
            ]);
    }
}
