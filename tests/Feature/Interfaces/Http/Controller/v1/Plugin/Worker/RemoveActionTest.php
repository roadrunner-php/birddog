<?php

declare(strict_types=1);

namespace Tests\Feature\Interfaces\Http\Controller\v1\Plugin\Worker;

use Tests\Feature\Interfaces\Http\Controller\ControllerTestCase;

final class RemoveActionTest extends ControllerTestCase
{
    public function testAddWorker(): void
    {
        $this->rpc
            ->withRegisteredServers('foo')
            ->shouldConnect('foo')
            ->assertCall('informer.RemoveWorker', 'bar');

        $this->http->removeWorker(server: 'foo', plugin: 'bar')
            ->assertStatusResource();
    }

    public function testAddWorkerForNotRegisteredServer(): void
    {
        $this->rpc->withRegisteredServers('foo');

        $this->http
            ->removeWorker(server: 'bar', plugin: 'baz')
            ->assertValidationErrors([
                'server' => 'Server is not registered.',
            ]);
    }

    public function testServerIsRequired(): void
    {
        $this->rpc->withRegisteredServers('foo');

        $this->http
            ->removeWorker(server: null, plugin: 'baz')
            ->assertValidationErrors([
                'server' => 'This value is required.',
            ]);
    }

    public function testPluginIsRequired(): void
    {
        $this->rpc->withRegisteredServers('foo');

        $this->http
            ->removeWorker(server: 'foo', plugin: null)
            ->assertValidationErrors([
                'plugin' => 'This value is required.',
            ]);
    }
}
