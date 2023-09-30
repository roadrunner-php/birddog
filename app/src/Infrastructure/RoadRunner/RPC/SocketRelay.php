<?php

declare(strict_types=1);

namespace App\Infrastructure\RoadRunner\RPC;

final class SocketRelay extends \Spiral\Goridge\SocketRelay
{
    public const CUSTOM_RECONNECT_RETRIES = 3;
    public const CUSTOM_RECONNECT_TIMEOUT = 1_000_000;

    public function connect(int $retries = self::RECONNECT_RETRIES, int $timeout = self::RECONNECT_TIMEOUT): bool
    {
        return parent::connect(
            retries: self::CUSTOM_RECONNECT_RETRIES,
            timeout: self::CUSTOM_RECONNECT_TIMEOUT,
        );
    }
}
