<?php

declare(strict_types=1);

namespace App\Module\Server\Event;

use App\Application\Centrifuge\Channel\PublicChannel;
use App\Application\Event\ShouldBroadcast;

final class Registered implements ShouldBroadcast
{
    public function __construct(
        public readonly string $name,
        public readonly string $address
    ) {
    }

    public function getEventName(): string|\Stringable
    {
        return 'server.registered';
    }

    public function getBroadcastTopics(): iterable|string|\Stringable
    {
        return new PublicChannel();
    }

    public function getPayload(): array|\JsonSerializable
    {
        return [
            'name' => $this->name,
            'address' => $this->address,
        ];
    }
}
