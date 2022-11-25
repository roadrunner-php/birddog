<?php

declare(strict_types=1);

namespace App\Application\Event;

interface ShouldBroadcast
{
    public function getEventName(): string|\Stringable;

    public function getBroadcastTopics(): iterable|string|\Stringable;

    public function getPayload(): array|\JsonSerializable;
}
