<?php

declare(strict_types=1);

namespace App\Application\Command\Server;

use Spiral\Cqrs\CommandInterface;

final class RegisterCommand implements CommandInterface
{
    public function __construct(
        public readonly string $name,
        public readonly string $address,
    ) {
    }
}
