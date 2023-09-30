<?php

declare(strict_types=1);

namespace App\Module\Jobs\Command;

use App\Application\Command\Jobs\DTO\PauseResult;
use App\Application\Command\Jobs\PauseCommand;
use App\Infrastructure\RoadRunner\RPC\RPCManagerInterface;
use Spiral\Cqrs\Attribute\CommandHandler;
use Spiral\Exceptions\ExceptionReporterInterface;

final readonly class PauseHandler
{
    public function __construct(
        private RPCManagerInterface $rpc,
        private ExceptionReporterInterface $reporter,
    ) {
    }

    #[CommandHandler]
    public function __invoke(PauseCommand $command): PauseResult
    {
        try {
            $this->rpc->connect($command->server)->pauseQueuePipeline($command->pipeline);
            $status = true;
        } catch (\Throwable $e) {
            $this->reporter->report($e);
            $status = false;
        }

        return new PauseResult(
            server: $command->server,
            pipeline: $command->pipeline,
            status: $status,
        );
    }
}
