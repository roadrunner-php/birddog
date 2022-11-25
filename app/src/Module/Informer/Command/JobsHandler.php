<?php

declare(strict_types=1);

namespace App\Module\Informer\Command;

use App\Application\Command\Informer\JobsQuery;
use App\Infrastructure\RPC\RPCManagerInterface;
use Spiral\Cqrs\Attribute\QueryHandler;
use Spiral\Goridge\RPC\Codec\JsonCodec;

final class JobsHandler
{
    public function __construct(
        private readonly RPCManagerInterface $rpc,
    ) {
    }

    #[QueryHandler]
    /**
     * @return non-empty-string[]
     */
    public function __invoke(JobsQuery $query): array
    {
        $rpc = $this->rpc->getServer($query->server, new JsonCodec());

        return (array) $rpc->call('informer.Jobs', $query->plugin);
    }
}
