<?php

declare(strict_types=1);

namespace Tests\Feature\Interfaces\Http\Controller\v1\Service;

use RoadRunner\Service\DTO\V1\PBList;
use RoadRunner\Service\DTO\V1\Service;
use Tests\Feature\Interfaces\Http\Controller\ControllerTestCase;

final class ListActionTest extends ControllerTestCase
{
    public function testListServices(): void
    {
        $this->rpc
            ->withRegisteredServers('foo')
            ->shouldConnect('foo')
            ->assertCall(
                'service.List',
                \Mockery::type(Service::class),
                PBList::class,
            )->andReturn(
                new PBList([
                    'services' => ['foo', 'bar'],
                ]),
            );

        $this->http
            ->serviceList(server: 'foo')
            ->assertJsonResponseSame([
                'data' => ['foo', 'bar'],
            ]);
    }

    public function testServerIsRequired(): void
    {
        $this->rpc->withRegisteredServers('foo');

        $this->http
            ->serviceList(server: null)
            ->assertValidationErrors([
                'server' => 'This value is required.',
            ]);
    }
}
