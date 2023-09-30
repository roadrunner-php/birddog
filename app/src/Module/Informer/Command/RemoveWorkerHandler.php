<?php

declare(strict_types=1);

namespace App\Module\Informer\Command;

use App\Application\Command\Informer\DTO\RemoveWorkerResult;
use App\Application\Command\Informer\RemoveWorkerCommand;
use App\Infrastructure\RoadRunner\RPC\RPCManagerInterface;
use Spiral\Cqrs\Attribute\CommandHandler;
use Spiral\Exceptions\ExceptionReporterInterface;

final readonly class RemoveWorkerHandler
{
    public function __construct(
        private RPCManagerInterface $rpc,
        private ExceptionReporterInterface $reporter,
    ) {
    }

    #[CommandHandler]
    public function __invoke(RemoveWorkerCommand $command): RemoveWorkerResult
    {
        try {
            $this->rpc->connect($command->server)->removeWorker($command->plugin);
            $status = true;
        } catch (\Throwable $e) {
            $this->reporter->report($e);
            $status = false;
        }

        return new RemoveWorkerResult(
            server: $command->server,
            plugin: $command->plugin,
            status: $status,
        );
    }
}
