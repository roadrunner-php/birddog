<?php

declare(strict_types=1);

namespace App\Application\Command\Settings;

use Spiral\Cqrs\CommandInterface;

final class StoreCommand implements CommandInterface
{
    public function __construct(
        public readonly array $settings,
    ) {
    }
}
