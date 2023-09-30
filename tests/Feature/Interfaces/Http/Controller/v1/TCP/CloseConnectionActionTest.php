<?php

declare(strict_types=1);

namespace Tests\Feature\Interfaces\Http\Controller\v1\TCP;

use Tests\Feature\Interfaces\Http\Controller\ControllerTestCase;

final class CloseConnectionActionTest extends ControllerTestCase
{
    public function testCloseConnection(): void
    {
        $this->rpc
            ->withRegisteredServers('foo')
            ->shouldConnect('foo')
            ->assertCall('tcp.Close', $uuid = $this->faker->uuid())
            ->andReturn(true);

        $this->http
            ->closeTcpConnection(server: 'foo', connectionUuid: $uuid)
            ->assertStatusResource();
    }

    public function testCloseConnectionFail(): void
    {
        $this->rpc
            ->withRegisteredServers('foo')
            ->shouldConnect('foo')
            ->assertCall('tcp.Close', $uuid = $this->faker->uuid())
            ->andReturn(false);

        $this->http
            ->closeTcpConnection(server: 'foo', connectionUuid: $uuid)
            ->assertStatusResource(false);
    }

    public function testServerIsRequired(): void
    {
        $this->rpc->withRegisteredServers('foo');

        $this->http
            ->closeTcpConnection(server: null, connectionUuid: $this->faker->uuid())
            ->assertValidationErrors([
                'server' => 'This value is required.',
            ]);
    }

    public function testConnectionUuidIsRequired(): void
    {
        $this->rpc->withRegisteredServers('foo');

        $this->http
            ->closeTcpConnection(server: 'foo', connectionUuid: null)
            ->assertValidationErrors([
                'uuid' => 'This value is required.',
            ]);
    }

    public function testConnectionUuidShouldBeValidUuid(): void
    {
        $this->rpc->withRegisteredServers('foo');

        $this->http
            ->closeTcpConnection(server: 'foo', connectionUuid: 'bar')
            ->assertValidationErrors([
                'uuid' => 'Invalid uuid.',
            ]);
    }
}
