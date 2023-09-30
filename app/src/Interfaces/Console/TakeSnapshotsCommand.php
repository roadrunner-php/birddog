<?php

declare(strict_types=1);

namespace App\Interfaces\Console;

use App\Application\Command\Metrics\GetMetricsQuery;
use App\Application\Command\Server\ListQuery;
use App\Infrastructure\VictoriaMetrics\ClientInterface;
use App\Infrastructure\VictoriaMetrics\Payload\Point;
use App\Infrastructure\VictoriaMetrics\Payload\Tag;
use Butschster\Prometheus\Ast\MetricDataNode;
use Psr\Log\LoggerInterface;
use RoadRunner\Logger\Logger as RoadRunnerLogger;
use Spiral\Console\Attribute\AsCommand;
use Spiral\Console\Attribute\Option;
use Spiral\Console\Command;
use Spiral\Cqrs\CommandBusInterface;
use Spiral\Cqrs\QueryBusInterface;

#[AsCommand(
    name: 'take:snapshots',
    description: 'Take snapshots of prometheus metrics for all RoadRunner instances'
)]
final class TakeSnapshotsCommand extends Command
{
    #[Option(description: 'Period of taking snapshots in seconds')]
    public int $period = 5;

    public function __invoke(
        QueryBusInterface $queryBus,
        CommandBusInterface $commandBus,
        ClientInterface $client,
        RoadRunnerLogger $logger,
    ): int {
        while (true) {
            $servers = $queryBus->ask(new ListQuery());
            $period = $this->period;

            \assert($period >= 5);

            foreach ($servers['servers'] as $server) {
                $points = [];

                /** @var array<non-empty-string, MetricDataNode> $metrics */
                $metrics = $queryBus->ask(new GetMetricsQuery($server->name));

                foreach ($metrics as $key => $metricNode) {
                    foreach ($metricNode->metrics as $metric) {
                        $point = new Point(
                            $metric->name,
                            $metric->value,
                        );

                        $point->addTag(new Tag('server', $server->name));
                        $point->addTag(new Tag('type', $metricNode->type));

                        foreach ($metric->labels as $label) {
                            $point->addTag(new Tag($label->name, $label->value));
                        }

                        $points[] = $point;
                    }
                }

                if ($points !== []) {
                    $client->put(...$points);
                }
            }

            sleep($period);
        }

        return self::SUCCESS;
    }
}
