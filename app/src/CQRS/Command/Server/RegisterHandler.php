<?php

declare(strict_types=1);

namespace App\CQRS\Command\Server;

use App\RPC\ServersRegistryInterface;
use Spiral\Cqrs\Attribute\CommandHandler;

final class RegisterHandler
{
    public function __construct(
        private readonly ServersRegistryInterface $registry
    ) {
    }

    #[CommandHandler]
    public function __invoke(RegisterCommand $command): void
    {
        $this->registry->addServer($command->name, $command->address);
    }
}
