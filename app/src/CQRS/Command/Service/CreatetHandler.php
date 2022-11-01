<?php

declare(strict_types=1);

namespace App\CQRS\Command\Service;

use App\RPC\RPCManagerInterface;
use Spiral\Cqrs\Attribute\CommandHandler;
use Spiral\RoadRunner\Services\Manager;

final class CreatetHandler
{
    public function __construct(
        private readonly RPCManagerInterface $rpc,
    ) {
    }

    #[CommandHandler]
    public function __invoke(CreateCommand $command): bool
    {
        $manager = new Manager($this->rpc->getServer($command->server));

        return $manager->create(
            name: $command->name,
            command: $command->command,
            processNum: $command->processNum,
            execTimeout: $command->execTimeout,
            remainAfterExit: $command->remainAfterExit,
            env: $command->env,
            restartSec: $command->restartSec
        );
    }
}
