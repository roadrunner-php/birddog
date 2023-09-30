<?php

declare(strict_types=1);

namespace App\Application\Command\Informer\DTO;

use App\Module\Informer\DTO\Plugin;

final readonly class PluginListResult
{
    /**
     * @param Plugin[] $plugins
     */
    public function __construct(
        public string $server,
        public array $plugins,
    ) {
    }
}
