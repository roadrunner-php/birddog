<?php

declare(strict_types=1);

namespace Tests\Feature\Interfaces\Http\Controller\v1\Plugin;

use Tests\Feature\Interfaces\Http\Controller\ControllerTestCase;

final class ListActionTest extends ControllerTestCase
{
    public function testListWorkers(): void
    {
        $client = $this->rpc
            ->withRegisteredServers('foo')
            ->shouldConnect('foo', times: 3);

        $client->assertCall('informer.List', null)
            ->andReturn(['baz', 'bar']);

        $client->assertCall('resetter.List', null)
            ->andReturn(['baz']);

        $client->assertCall('informer.Workers', 'baz')
            ->andReturnWorkerList();

        $client->assertCall('informer.Workers', 'bar')
            ->andReturnWorkerList();

        $this->http
            ->listPlugins(server: 'foo')
            ->assertJsonResponseSame([
                'data' => [
                    [
                        'name' => 'bar',
                        'is_resettable' => false,
                        'workers' => [
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
                        ],
                    ],
                    [
                        'name' => 'baz',
                        'is_resettable' => true,
                        'workers' => [
                            'data' => [
                                [
                                    'plugin' => 'baz',
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
                                    'plugin' => 'baz',
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
                                    'plugin' => 'baz',
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
                        ],
                    ],
                ],
                'meta' => [
                    'grid' => [
                        'filters' => [],
                        'sorters' => [
                            'name' => 'asc',
                        ],
                    ],
                ],
            ]);
    }

    public function testServerShouldBeRegistered(): void
    {
        $this->rpc->withRegisteredServers('bar');

        $this->http
            ->listPlugins(server: 'foo')
            ->assertValidationErrors([
                'server' => 'Server is not registered.',
            ]);
    }

    public function testServerIsRequired(): void
    {
        $this->rpc->withRegisteredServers('foo');

        $this->http
            ->listPlugins(server: null)
            ->assertValidationErrors([
                'server' => 'This value is required.',
            ]);
    }
}
