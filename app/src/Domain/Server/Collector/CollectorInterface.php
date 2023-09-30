<?php

declare(strict_types=1);

namespace App\Domain\Server\Collector;

use App\Infrastructure\RoadRunner\RPC\ValueObject\Server;
use App\Module\Informer\DTO\Plugin;

interface CollectorInterface
{
    public function canCollect(Plugin $plugin): bool;

    public function collect(Server $server, Plugin $plugin): void;
}
