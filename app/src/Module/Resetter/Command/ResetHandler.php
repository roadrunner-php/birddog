<?php

declare(strict_types=1);

namespace App\Module\Resetter\Command;

use App\Application\Command\Resetter\DTO\ResetResult;
use App\Application\Command\Resetter\ResetCommand;
use App\Infrastructure\RoadRunner\RPC\RPCManagerInterface;
use Spiral\Cqrs\Attribute\CommandHandler;
use Spiral\Exceptions\ExceptionReporterInterface;

final readonly class ResetHandler
{
    public function __construct(
        private RPCManagerInterface $rpc,
        private ExceptionReporterInterface $reporter,
    ) {
    }

    #[CommandHandler]
    public function __invoke(ResetCommand $command): ResetResult
    {
        try {
            $status = $this->rpc->connect($command->server)->resetPlugin($command->plugin);
        } catch (\Throwable $e) {
            $this->reporter->report($e);
            $status = false;
        }

        return new ResetResult(
            server: $command->server,
            plugin: $command->plugin,
            status: $status,
        );
    }
}
