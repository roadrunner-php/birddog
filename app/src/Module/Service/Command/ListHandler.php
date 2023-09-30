<?php

declare(strict_types=1);

namespace App\Module\Service\Command;

use App\Application\Command\Service\DTO\ListResult;
use App\Application\Command\Service\ListQuery;
use App\Infrastructure\RoadRunner\RPC\RPCManagerInterface;
use Spiral\Cqrs\Attribute\QueryHandler;
use Spiral\Exceptions\ExceptionReporterInterface;
use Spiral\RoadRunner\Services\Manager;

final readonly class ListHandler
{
    public function __construct(
        private RPCManagerInterface $rpc,
        private ExceptionReporterInterface $reporter,
    ) {
    }

    #[QueryHandler]
    public function __invoke(ListQuery $query): ListResult
    {
        $manager = new Manager($this->rpc->connect($query->server)->getRpc());

        try {
            $services = $manager->list();
        } catch (\Throwable $e) {
            $this->reporter->report($e);
            $services = [];
        }

        return new ListResult(
            server: $query->server,
            services: $services,
        );
    }
}
