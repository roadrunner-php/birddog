<?php

declare(strict_types=1);

namespace App\Module\Jobs\Command;

use App\Application\Command\Jobs\DTO\ResumeResult;
use App\Application\Command\Jobs\ResumeCommand;
use App\Infrastructure\RoadRunner\RPC\RPCManagerInterface;
use Spiral\Cqrs\Attribute\CommandHandler;
use Spiral\Exceptions\ExceptionReporterInterface;

final readonly class ResumeHandler
{
    public function __construct(
        private RPCManagerInterface $rpc,
        private ExceptionReporterInterface $reporter,
    ) {
    }

    #[CommandHandler]
    public function __invoke(ResumeCommand $command): ResumeResult
    {
        try {
            $this->rpc->connect($command->server)->resumeQueuePipeline($command->pipeline);
            $status = true;
        } catch (\Throwable $e) {
            $this->reporter->report($e);
            $status = false;
        }

        return new ResumeResult(
            server: $command->server,
            pipeline: $command->pipeline,
            status: $status,
        );
    }
}
