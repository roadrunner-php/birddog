<?php

declare(strict_types=1);

namespace App\CQRS\Command\Jobs;

use App\RPC\RPCManagerInterface;
use Spiral\Cqrs\Attribute\CommandHandler;
use Spiral\RoadRunner\Jobs\Jobs;

final class ResumeHandler
{
    public function __construct(
        private readonly RPCManagerInterface $rpc,
    ) {
    }

    #[CommandHandler]
    public function __invoke(ResumeCommand $command): void
    {
        $rpc = $this->rpc->getServer($command->server);
        $jobs = new Jobs($rpc);

        $jobs->resume($command->pipeline);
    }
}
