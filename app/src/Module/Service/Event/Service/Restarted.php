<?php

declare(strict_types=1);

namespace App\Module\Service\Event\Service;

use App\Application\Centrifuge\Channel\ServerChannel;
use App\Application\Event\ShouldBroadcast;

final readonly class Restarted implements ShouldBroadcast
{
    public function __construct(
        public string $server,
        public string $service
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
        ];
    }
}
