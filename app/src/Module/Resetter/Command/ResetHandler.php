<?php

declare(strict_types=1);

namespace App\Module\Resetter\Command;

use App\Application\Command\Resetter\ResetCommand;
use App\Infrastructure\RPC\RPCManagerInterface;
use Spiral\Cqrs\Attribute\CommandHandler;
use Spiral\Goridge\RPC\Codec\JsonCodec;

final class ResetHandler
{
    public function __construct(
        private readonly RPCManagerInterface $rpc,
    ) {
    }

    #[CommandHandler]
    public function __invoke(ResetCommand $command): bool
    {
        $rpc = $this->rpc->getServer($command->server, new JsonCodec());

        return (bool)$rpc->call('resetter.Reset', $command->plugin);
    }
}
