<?php

declare(strict_types=1);

namespace App\Infrastructure\RPC;

final class SocketRelay extends \Spiral\Goridge\SocketRelay
{
    public const RECONNECT_RETRIES = 3;
    public const RECONNECT_TIMEOUT = 1_000_000;
}
