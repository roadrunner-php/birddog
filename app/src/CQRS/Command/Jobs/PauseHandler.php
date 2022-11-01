<?php

declare(strict_types=1);

namespace App\CQRS\Command\Jobs;

use App\RPC\RPCManagerInterface;
use Spiral\Cqrs\Attribute\CommandHandler;
use Spiral\RoadRunner\Jobs\Jobs;

final class PauseHandler
{
    public function __construct(
        private readonly RPCManagerInterface $rpc,
    ) {
    }

    #[CommandHandler]
    public function __invoke(PauseCommand $command): void
    {
        $rpc = $this->rpc->getServer($command->server);
        $jobs = new Jobs($rpc);

        $jobs->pause($command->pipeline);
    }
}
