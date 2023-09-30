<?php

declare(strict_types=1);

namespace Tests\Feature\Interfaces\Http\Controller\v1\Service;

use RoadRunner\Service\DTO\V1\Service;
use RoadRunner\Service\DTO\V1\Statuses;
use Tests\Feature\Interfaces\Http\Controller\ControllerTestCase;

final class StatusActionTest extends ControllerTestCase
{
    public function testStatusService(): void
    {
        $this->rpc
            ->withRegisteredServers('foo')
            ->shouldConnect('foo')
            ->assertCall(
                'service.Statuses',
                \Mockery::on(function (Service $service) {
                    $this->assertSame('bar', $service->getName());

                    return true;
                }),
                Statuses::class,
            )->andReturn(
                new Statuses([
                    'status' => [
                        new \RoadRunner\Service\DTO\V1\Status([
                            'cpu_percent' => 0.5,
                            'pid' => 1,
                            'memory_usage' => 1024,
                            'command' => '/vendor/bin/rr serve',
                        ]),
                        new \RoadRunner\Service\DTO\V1\Status([
                            'cpu_percent' => 1,
                            'pid' => 2,
                            'memory_usage' => 2048,
                            'command' => '/vendor/bin/rr serve',
                        ]),
                    ],
                ]),
            );

        $this->http
            ->serviceStatus(server: 'foo', service: 'bar')
            ->assertJsonResponseSame([
                'data' => [
                    [
                        'command' => '/vendor/bin/rr serve',
                        'cpu_percent' => 0.5,
                        'memory_usage' => 1024,
                        'pid' => 1,
                        'error' => null,
                    ],
                    [
                        'command' => '/vendor/bin/rr serve',
                        'cpu_percent' => 1,
                        'memory_usage' => 2048,
                        'pid' => 2,
                        'error' => null,
                    ],
                ],
                'meta' => [
                    'grid' => [],
                ],
            ]);
    }

    public function testServerIsRequired(): void
    {
        $this->rpc->withRegisteredServers('foo');

        $this->http
            ->serviceStatus(server: null, service: 'bar')
            ->assertValidationErrors([
                'server' => 'This value is required.',
            ]);
    }

    public function testServiceIsRequired(): void
    {
        $this->rpc->withRegisteredServers('foo');

        $this->http
            ->serviceStatus(server: 'foo', service: null)
            ->assertValidationErrors([
                'service' => 'This value is required.',
            ]);
    }
}
