<?php

declare(strict_types=1);

namespace Tests\Feature\Interfaces\Http\Controller\v1\Server;

use App\Application\Centrifuge\Channel\PublicChannel;
use App\Domain\Server\Service\ServersRegistryInterface;
use Spiral\Broadcasting\BroadcastInterface;
use Tests\Feature\Interfaces\Http\Controller\ControllerTestCase;

final class RegisterActionTest extends ControllerTestCase
{
    public function testRegisterServers(): void
    {
        $registry = $this->mockContainer(ServersRegistryInterface::class);

        $registry->shouldReceive('addServer')
            ->once()
            ->with('foo', 'tcp://127.0.0.1:6001');

        $broadcast = $this->mockContainer(BroadcastInterface::class);
        $broadcast->shouldReceive('publish')
            ->once()
            ->with(
                \Mockery::type(PublicChannel::class),
                json_encode([
                    'event' => 'server.registered',
                    'data' => [
                        'name' => 'foo',
                        'address' => 'tcp://127.0.0.1:6001',
                    ],
                ]),
            );

        $this->http
            ->registerServer(name: 'foo', address: 'tcp://127.0.0.1:6001')
            ->assertStatusResource();
    }

    public function testNameIsRequired(): void
    {
        $this->http
            ->registerServer(name: null, address: 'tcp://127.0.0.1:6001')
            ->assertValidationErrors([
                'name' => 'This value is required.',
            ]);
    }

    public function testAddressIsRequired(): void
    {
        $this->http
            ->registerServer(name: 'foo', address: null)
            ->assertValidationErrors([
                'address' => 'This value is required.',
            ]);
    }

    public function testAddressShouldBeValid(): void
    {
        $this->http
            ->registerServer(name: 'foo', address: 'test')
            ->assertValidationErrors([
                'address' => 'Invalid TCP address.',
            ]);
    }
}
