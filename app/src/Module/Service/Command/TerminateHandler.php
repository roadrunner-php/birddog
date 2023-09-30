<?php

declare(strict_types=1);

namespace App\Module\Service\Command;

use App\Application\Command\Service\DTO\TerminateResult;
use App\Application\Command\Service\TerminateCommand;
use App\Infrastructure\RoadRunner\RPC\RPCManagerInterface;
use App\Module\Service\Event\Service\Restarted;
use App\Module\Service\Event\Service\Terminated;
use Psr\EventDispatcher\EventDispatcherInterface;
use Spiral\Cqrs\Attribute\CommandHandler;
use Spiral\Exceptions\ExceptionReporterInterface;
use Spiral\RoadRunner\Services\Manager;

final readonly class TerminateHandler
{
    public function __construct(
        private RPCManagerInterface $rpc,
        private EventDispatcherInterface $dispatcher,
        private ExceptionReporterInterface $reporter
    ) {
    }

    #[CommandHandler]
    public function __invoke(TerminateCommand $command): TerminateResult
    {
        $manager = new Manager($this->rpc->connect($command->server)->getRpc());

        try {
            $status = $manager->terminate($command->service);

            $this->dispatcher->dispatch(
                new Terminated($command->server, $command->service),
            );
        } catch (\Throwable $e) {
            $this->reporter->report($e);
            $status = false;
        }

        return new TerminateResult(
            server: $command->server,
            service: $command->service,
            status: $status,
        );
    }
}
