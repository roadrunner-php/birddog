<?php

declare(strict_types=1);

namespace App\Interfaces\Console;

use App\Domain\Server\Collector\DataCollector;
use App\Infrastructure\DataGrid\ConsoleInput;
use App\Infrastructure\RoadRunner\RPC\RPCManagerInterface;
use Spiral\Console\Attribute\AsCommand;
use Spiral\Console\Attribute\Option;
use Spiral\Console\Command;
use Spiral\Core\ScopeInterface;
use Spiral\Cqrs\QueryBusInterface;
use Spiral\DataGrid\InputInterface;
use Spiral\Exceptions\ExceptionReporterInterface;

#[AsCommand(
    name: 'server:collect',
    description: 'Collect information about RoadRunner instances.'
)]
final class CollectInformationCommand extends Command
{
    #[Option(description: 'Period of taking snapshots in seconds')]
    public int $period = 1;

    public function __invoke(
        DataCollector $collector,
        ScopeInterface $scope,
        RPCManagerInterface $manager,
        ExceptionReporterInterface $reporter,
    ): int {
        $tries = 20;
        while (true) {
            try {
                $scope->runScope([
                    InputInterface::class => new ConsoleInput($this->defineArguments()),
                ], static fn() => $collector->collect());

                $tries = 20;
            } catch (\Throwable $e) {
                $reporter->report($e);
                $tries--;
            }

            if ($tries === 0) {
                return self::FAILURE;
            }

            \usleep($this->period * 1000000);
        }

        return self::SUCCESS;
    }
}
