<?php

declare(strict_types=1);

namespace App\CQRS\Command\Service;

use App\Event\Service\Restarted;
use App\RPC\RPCManagerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Spiral\Cqrs\Attribute\CommandHandler;
use Spiral\RoadRunner\Services\Manager;

final class RestartHandler
{
    public function __construct(
        private readonly RPCManagerInterface $rpc,
        private readonly EventDispatcherInterface $dispatcher,
    ) {
    }

    #[CommandHandler]
    public function __invoke(RestartCommand $command): bool
    {
        $manager = new Manager($this->rpc->getServer($command->server));

        $status = $manager->restart($command->service);

        $this->dispatcher->dispatch(
            new Restarted($command->server, $command->service, $status)
        );

        return $status;
    }
}
