<?php

declare(strict_types=1);

namespace App\Module\TCP\Command;

use App\Application\Command\TCP\CloseCommand;
use App\Application\Command\TCP\DTO\CloseResult;
use App\Infrastructure\RoadRunner\RPC\RPCManagerInterface;
use Spiral\Cqrs\Attribute\CommandHandler;
use Spiral\Exceptions\ExceptionReporterInterface;

final readonly class CloseHandler
{
    public function __construct(
        private RPCManagerInterface $rpc,
        private ExceptionReporterInterface $reporter,
    ) {
    }

    #[CommandHandler]
    public function __invoke(CloseCommand $command): CloseResult
    {
        try {
            $status = $this->rpc->connect($command->server)
                ->closeTcpConnection($command->connectionUuid);

            // TODO: fire event

        } catch (\Throwable $e) {
            $this->reporter->report($e);
            $status = false;
        }

        return new CloseResult(
            server: $command->server,
            connectionUuid: $command->connectionUuid,
            status: $status,
        );
    }
}
