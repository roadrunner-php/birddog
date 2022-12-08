<?php

declare(strict_types=1);

namespace App\Infrastructure\RPC;

use Spiral\Goridge\RPC\CodecInterface;
use Spiral\Goridge\RPC\RPCInterface;

interface RPCManagerInterface
{
    public function getServer(string $server, ?CodecInterface $codec = null): RPCInterface;
}
