<?php

declare(strict_types=1);

namespace App\Module\Service\Command;

use App\Application\Command\Service\TerminateCommand;
use App\Infrastructure\RPC\RPCManagerInterface;
use Spiral\Cqrs\Attribute\CommandHandler;
use Spiral\RoadRunner\Services\Manager;

final class TerminateHandler
{
    public function __construct(
        private readonly RPCManagerInterface $rpc,
    ) {
    }

    #[CommandHandler]
    public function __invoke(TerminateCommand $command): bool
    {
        $manager = new Manager($this->rpc->getServer($command->server));

        return $manager->terminate($command->service);
    }
}
