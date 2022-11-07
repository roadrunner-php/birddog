<?php

declare(strict_types=1);

namespace App\Event\Service;

use App\Centrifuge\Channel\ServerChannel;
use App\Event\ShouldBroadcast;

class Restarted implements ShouldBroadcast
{
    public function __construct(
        public readonly string $server,
        public readonly string $service,
        public readonly bool $status
    ) {
    }

    public function getEventName(): string|\Stringable
    {
        return 'service.restarted';
    }

    public function getBroadcastTopics(): iterable|string|\Stringable
    {
        return new ServerChannel($this->server);
    }

    public function getPayload(): array|\JsonSerializable
    {
        return [
            'server' => $this->server,
            'service' => $this->service,
            'status' => $this->status,
        ];
    }
}
