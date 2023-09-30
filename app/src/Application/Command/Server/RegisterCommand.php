<?php

declare(strict_types=1);

namespace App\Application\Command\Server;

use App\Application\Command\Server\DTO\RegisterResult;
use Spiral\Cqrs\CommandInterface;

/**
 * @implements CommandInterface<RegisterResult>
 */
final readonly class RegisterCommand implements CommandInterface
{
    public function __construct(
        public string $name,
        public string $address,
    ) {
    }
}
