<?php

declare(strict_types=1);

namespace App\Module\RoadRunner\Command;

use App\Application\Command\RoadRunner\DTO\GetConfigResult;
use App\Application\Command\RoadRunner\GetConfigQuery;
use App\Infrastructure\RoadRunner\RPC\RPCManagerInterface;
use Spiral\Cqrs\Attribute\QueryHandler;
use Spiral\Exceptions\ExceptionReporterInterface;

final readonly class GetConfigHandler
{
    public function __construct(
        private RPCManagerInterface $rpc,
        private ExceptionReporterInterface $reporter,
    ) {
    }

    #[QueryHandler]
    public function __invoke(GetConfigQuery $query): GetConfigResult
    {
        try {
            $config = $this->rpc->connect($query->server)->getConfig();
        } catch (\Throwable $e) {
            $this->reporter->report($e);
            $config = [];
        }

        return new GetConfigResult(
            server: $query->server,
            config: $config,
        );
    }
}
