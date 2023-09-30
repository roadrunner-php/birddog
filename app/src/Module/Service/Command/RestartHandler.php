<?php

declare(strict_types=1);

namespace App\Module\Service\Command;

use App\Application\Command\Service\DTO\RestartResult;
use App\Application\Command\Service\RestartCommand;
use App\Infrastructure\RoadRunner\RPC\RPCManagerInterface;
use App\Module\Service\Event\Service\Restarted;
use Psr\EventDispatcher\EventDispatcherInterface;
use Spiral\Cqrs\Attribute\CommandHandler;
use Spiral\Exceptions\ExceptionReporterInterface;
use Spiral\RoadRunner\Services\Manager;

final readonly class RestartHandler
{
    public function __construct(
        private RPCManagerInterface $rpc,
        private EventDispatcherInterface $dispatcher,
        private ExceptionReporterInterface $reporter
    ) {
    }

    #[CommandHandler]
    public function __invoke(RestartCommand $command): RestartResult
    {
        try {
            $manager = new Manager($this->rpc->connect($command->server)->getRpc());

            $status = $manager->restart($command->service);

            $this->dispatcher->dispatch(
                new Restarted($command->server, $command->service),
            );
        } catch (\Throwable $e) {
            $this->reporter->report($e);
            $status = false;
        }

        return new RestartResult(
            server: $command->server,
            service: $command->service,
            status: $status,
        );
    }
}
