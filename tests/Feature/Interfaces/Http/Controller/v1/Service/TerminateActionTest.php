<?php

declare(strict_types=1);

namespace Tests\Feature\Interfaces\Http\Controller\v1\Service;

use App\Application\Centrifuge\Channel\ServerChannel;
use RoadRunner\Service\DTO\V1\Response;
use RoadRunner\Service\DTO\V1\Service;
use Spiral\Broadcasting\BroadcastInterface;
use Tests\Feature\Interfaces\Http\Controller\ControllerTestCase;

final class TerminateActionTest extends ControllerTestCase
{
    public function testTerminateService(): void
    {
        $this->rpc
            ->withRegisteredServers('foo')
            ->shouldConnect('foo')
            ->assertCall(
                'service.Terminate',
                \Mockery::on(function (Service $service) {
                    $this->assertSame('bar', $service->getName());

                    return true;
                }),
                Response::class,
            )->andReturn(
                new Response([
                    'ok' => true,
                ]),
            );

        $broadcast = $this->mockContainer(BroadcastInterface::class);
        $broadcast->shouldReceive('publish')
            ->once()
            ->with(
                \Mockery::on(function (ServerChannel $channel) {
                    $this->assertSame('server.foo', (string)$channel);

                    return true;
                }),
                json_encode([
                    'event' => 'service.terminated',
                    'data' => [
                        'server' => 'foo',
                        'service' => 'bar',
                    ],
                ]),
            );

        $this->http
            ->serviceTerminate(server: 'foo', service: 'bar')
            ->assertStatusResource();
    }

    public function testServerIsRequired(): void
    {
        $this->rpc->withRegisteredServers('foo');

        $this->http
            ->serviceTerminate(server: null, service: 'bar')
            ->assertValidationErrors([
                'server' => 'This value is required.',
            ]);
    }

    public function testServiceIsRequired(): void
    {
        $this->rpc->withRegisteredServers('foo');

        $this->http
            ->serviceTerminate(server: 'foo', service: null)
            ->assertValidationErrors([
                'service' => 'This value is required.',
            ]);
    }
}
