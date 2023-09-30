<?php

declare(strict_types=1);

namespace App\Module\Informer\Command;

use App\Application\Command\Informer\AddWorkerCommand;
use App\Application\Command\Informer\DTO\AddWorkerResult;
use App\Infrastructure\RoadRunner\RPC\RPCManagerInterface;
use Spiral\Cqrs\Attribute\CommandHandler;
use Spiral\Exceptions\ExceptionReporterInterface;

final readonly class AddWorkerHandler
{
    public function __construct(
        private RPCManagerInterface $rpc,
        private ExceptionReporterInterface $reporter,
    ) {
    }

    #[CommandHandler]
    public function __invoke(AddWorkerCommand $command): AddWorkerResult
    {
        try {
            $this->rpc->connect($command->server)->addWorker($command->plugin);
            $status = true;
        } catch (\Throwable $e) {
            $this->reporter->report($e);
            $status = false;
        }

        return new AddWorkerResult(
            server: $command->server,
            plugin: $command->plugin,
            status: $status,
        );
    }
}
