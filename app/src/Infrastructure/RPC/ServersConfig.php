<?php

declare(strict_types=1);

namespace App\Infrastructure\RPC;

use Spiral\Core\InjectableConfig;

final class ServersConfig extends InjectableConfig
{
    protected const CONFIG = 'rpc_servers';

    protected array $config = [
        'default' => null,
        'servers' => [],
    ];

    public function getDefaultServer(): ?string
    {
        return $this->config['default'];
    }

    public function getServers(): array
    {
        return $this->config['servers'];
    }
}
