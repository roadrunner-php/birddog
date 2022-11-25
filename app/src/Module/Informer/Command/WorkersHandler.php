<?php

declare(strict_types=1);

namespace App\Module\Informer\Command;

use App\Application\Command\Informer\WorkersQuery;
use App\Infrastructure\RPC\RPCManagerInterface;
use App\Module\Informer\Schema\WorkersSchema;
use Spiral\Cqrs\Attribute\QueryHandler;
use Spiral\DataGrid\GridInterface;
use Spiral\Goridge\RPC\Codec\JsonCodec;

final class WorkersHandler
{
    public function __construct(
        private readonly RPCManagerInterface $rpc,
        private readonly WorkersSchema $schema,
    ) {
    }

    #[QueryHandler]
    public function __invoke(WorkersQuery $query): GridInterface
    {
        $rpc = $this->rpc->getServer($query->server, new JsonCodec());

        return $this->schema->create(
            $rpc->call('informer.Workers', $query->plugin)['workers'] ?? []
        );
    }
}
