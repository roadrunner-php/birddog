<?php

declare(strict_types=1);

namespace tests\Feature\Interfaces\Http\Controller\v1\Jobs\Pipeline;

use RoadRunner\Jobs\DTO\V1\Stat;
use RoadRunner\Jobs\DTO\V1\Stats;
use Tests\Feature\Interfaces\Http\Controller\ControllerTestCase;

final class ListActionTest extends ControllerTestCase
{
    public function testListPipelines(): void
    {
        $this->rpc
            ->withRegisteredServers('foo')
            ->shouldConnect('foo')
            ->assertCall('jobs.Stat', '', Stats::class)
            ->andReturnQueuePipelineList(new Stats([
                'stats' => [
                    new Stat(
                        [
                            'pipeline' => 'test',
                            'driver' => 'amqp',
                            'queue' => 'low-priority',
                            'priority' => 4,
                            'active' => 1,
                            'delayed' => 0,
                            'reserved' => 1,
                            'ready' => true,
                        ],
                    ),
                    new Stat(
                        [
                            'pipeline' => 'local',
                            'driver' => 'memory',
                            'queue' => '',
                            'priority' => 1,
                            'active' => 1,
                            'delayed' => 0,
                            'reserved' => 1,
                            'ready' => true,
                        ],
                    )
                ],
            ]));

        $this->http
            ->jobPipelineList(server: 'foo')
            ->assertJsonResponseSame([
                'data' => [
                    [
                        'pipeline' => 'local',
                        'driver' => 'memory',
                        'queue' => '',
                        'priority' => 1,
                        'active' => 1,
                        'delayed' => 0,
                        'reserved' => 1,
                        'ready' => true,
                    ],
                    [
                        'pipeline' => 'test',
                        'driver' => 'amqp',
                        'queue' => 'low-priority',
                        'priority' => 4,
                        'active' => 1,
                        'delayed' => 0,
                        'reserved' => 1,
                        'ready' => true,
                    ],
                ],
                'meta' => [
                    'grid' => [
                        'filters' => [],
                        'sorters' => ['pipeline' => 'asc'],
                    ],
                ],
            ]);
    }

    public function testServerIsRequired(): void
    {
        $this->rpc->withRegisteredServers('foo');

        $this->http
            ->jobPipelineList(server: null)
            ->assertValidationErrors([
                'server' => 'This value is required.',
            ]);
    }
}
