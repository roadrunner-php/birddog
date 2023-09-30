<?php

declare(strict_types=1);

namespace Tests\Feature\Interfaces\Http\Controller\v1\Plugin\Worker;

use Tests\Feature\Interfaces\Http\Controller\ControllerTestCase;

final class ListActionTest extends ControllerTestCase
{
    public function testListWorkers(): void
    {
        $this->rpc
            ->withRegisteredServers('foo')
            ->shouldConnect('foo')
            ->assertCall('informer.Workers', 'bar')
            ->andReturnWorkerList();

        $this->http->listWorkers(server: 'foo', plugin: 'bar')
            ->assertJsonResponseSame([
                'data' => [
                    [
                        'plugin' => 'bar',
                        "pid" => 1,
                        "cpu_percent" => 0.2586069315593,
                        "memory_usage" => 51699712,
                        "command" => '/usr/bin/npm run dev',
                        "num_execs" => 0,
                        "status" => 1,
                        "status_string" => "",
                        "created_at" => "1970-01-01T00:00:00+00:00",
                    ],
                    [
                        'plugin' => 'bar',
                        "pid" => 3,
                        "cpu_percent" => 0.080640060408347,
                        "memory_usage" => 49577984,
                        "command" => "",
                        "num_execs" => 3,
                        "status" => 2,
                        "status_string" => "working",
                        "created_at" => "2023-09-30T08:59:01+00:00",
                    ],
                    [
                        'plugin' => 'bar',
                        "pid" => 4,
                        "cpu_percent" => 0.068126334280511,
                        "memory_usage" => 46551040,
                        "command" => "",
                        "num_execs" => 0,
                        "status" => 1,
                        "status_string" => "ready",
                        "created_at" => "2023-09-30T08:59:01+00:00",
                    ],
                ],
                'meta' => [
                    'grid' => [
                        'filters' => [],
                        'sorters' => [
                            'pid' => 'asc',
                        ],
                    ],
                ],
            ]);
    }

    public function testServerShouldBeRegistered(): void
    {
        $this->rpc->withRegisteredServers('bar');

        $this->http
            ->listWorkers(server: 'foo', plugin: 'bar')
            ->assertValidationErrors([
                'server' => 'Server is not registered.',
            ]);
    }


    public function testServerIsRequired(): void
    {
        $this->rpc->withRegisteredServers('foo');

        $this->http
            ->listWorkers(server: null, plugin: 'bar')
            ->assertValidationErrors([
                'server' => 'This value is required.',
            ]);
    }

    public function testPluginIsRequired(): void
    {
        $this->rpc->withRegisteredServers('foo');

        $this->http
            ->listWorkers(server: 'foo', plugin: null)
            ->assertValidationErrors([
                'plugin' => 'This value is required.',
            ]);
    }
}
