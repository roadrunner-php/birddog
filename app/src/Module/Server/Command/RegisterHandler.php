<?php

declare(strict_types=1);

namespace App\Module\Server\Command;

use App\Application\Command\Server\RegisterCommand;
use App\Infrastructure\RPC\ServersRegistryInterface;
use App\Module\Server\Event\Registered;
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
