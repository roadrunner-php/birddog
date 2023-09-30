<?php

declare(strict_types=1);

namespace App\Module\Service\Command;

use App\Application\Command\Service\CreateCommand;
use App\Application\Command\Service\DTO\CreateResult;
use App\Infrastructure\RoadRunner\RPC\RPCManagerInterface;
use Spiral\Cqrs\Attribute\CommandHandler;
use Spiral\Exceptions\ExceptionReporterInterface;
use Spiral\RoadRunner\Services\Manager;

final readonly class CreateHandler
{
    public function __construct(
        private RPCManagerInterface $rpc,
        private ExceptionReporterInterface $reporter,
    ) {
    }

    #[CommandHandler]
    public function __invoke(CreateCommand $command): CreateResult
    {
        $manager = new Manager($this->rpc->connect($command->server)->getRpc());

        try {
            $result = $manager->create(
                name: $command->name,
                command: $command->command,
                processNum: $command->processNum,
                execTimeout: $command->execTimeout,
                remainAfterExit: $command->remainAfterExit,
                env: $command->env,
                restartSec: $command->restartSec,
            );
        } catch (\Throwable $e) {
            $this->reporter->report($e);
            $result = false;
        }

        // TODO: fire event

        return new CreateResult(
            server: $command->server,
            status: $result,
        );
    }
}
