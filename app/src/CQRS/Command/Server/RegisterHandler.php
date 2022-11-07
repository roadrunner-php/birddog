<?php

declare(strict_types=1);

namespace App\CQRS\Command\Server;

use App\Event\Server\Registered;
use App\RPC\ServersRegistryInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Spiral\Cqrs\Attribute\CommandHandler;

final class RegisterHandler
{
    public function __construct(
        private readonly ServersRegistryInterface $registry,
        private readonly EventDispatcherInterface $dispatcher,
    ) {
    }

    #[CommandHandler]
    public function __invoke(RegisterCommand $command): void
    {
        $this->registry->addServer($command->name, $command->address);

        $this->dispatcher->dispatch(
            new Registered($command->name, $command->address)
        );
    }
}
