<?php

declare(strict_types=1);

namespace App\Infrastructure\RoadRunner\RPC;

use App\Domain\Server\Service\ServersRegistryInterface;
use Spiral\Goridge\RPC\CodecInterface;

/**
 * @psalm-import-type TName from ServersRegistryInterface
 * @psalm-import-type THost from ServersRegistryInterface
 */
interface RPCManagerInterface
{
    /**
     * Get RPC client for server.
     *
     * @param TName|THost $server
     */
    public function connect(string $server): RPCClient;
}
