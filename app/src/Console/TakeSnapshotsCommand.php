<?php

declare(strict_types=1);

namespace App\Console;

use App\CQRS\Query\Metrics\GetMetricsQuery;
use App\CQRS\Query\Server\ListQuery;
use App\VictoriaMetrics\ClientInterface;
use App\VictoriaMetrics\Payload\Point;
use App\VictoriaMetrics\Payload\Tag;
use Butschster\Prometheus\Ast\MetricDataNode;
use Spiral\Console\Command;
use Spiral\Cqrs\CommandBusInterface;
use Spiral\Cqrs\QueryBusInterface;

final class TakeSnapshotsCommand extends Command
{
    protected const SIGNATURE = 'take:snapshots {--period=5}';
    protected const DESCRIPTION = 'Take snapshots of prometheus metrics for all RoadRunner instances';

    public function __invoke(
        QueryBusInterface $queryBus,
        CommandBusInterface $commandBus,
        ClientInterface $client,
    ): int {
        while (true) {
            $servers = $queryBus->ask(new ListQuery());
            $period = (int)$this->option('period') ?? 5;

            \assert($period >= 5);

            foreach ($servers['servers'] as $server) {
                $points = [];

                /** @var array<non-empty-string, MetricDataNode> $metrics */
                $metrics = $queryBus->ask(new GetMetricsQuery($server));

                foreach ($metrics as $key => $metricNode) {
                    foreach ($metricNode->metrics as $metric) {
                        $point = new Point(
                            $metric->name,
                            $metric->value,
                        );

                        $point->addTag(new Tag('server', $server));
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
