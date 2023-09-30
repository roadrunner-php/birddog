<?php

declare(strict_types=1);

namespace App\Module\Server\Command;

use App\Application\Command\Server\DTO\RegisterResult;
use App\Application\Command\Server\RegisterCommand;
use App\Domain\Server\Service\ServersRegistryInterface;
use App\Module\Server\Event\Registered;
use Psr\EventDispatcher\EventDispatcherInterface;
use Spiral\Cqrs\Attribute\CommandHandler;

final readonly class RegisterHandler
{
    public function __construct(
        private ServersRegistryInterface $servers,
        private EventDispatcherInterface $dispatcher,
    ) {
    }

    #[CommandHandler]
    public function __invoke(RegisterCommand $command): RegisterResult
    {
        $this->servers->addServer($command->name, $command->address);

        $this->dispatcher->dispatch(
            new Registered($command->name, $command->address)
        );

        return new RegisterResult(
            status: true
        );
    }
}
