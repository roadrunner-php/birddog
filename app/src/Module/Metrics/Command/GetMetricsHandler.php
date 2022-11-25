<?php

declare(strict_types=1);

namespace App\Module\Metrics\Command;

use App\Application\Command\Metrics\GetMetricsQuery;
use App\Application\Command\RoadRunner\GetConfigQuery;
use App\Infrastructure\RPC\ServersRegistryInterface;
use Butschster\Prometheus\Parser;
use Nyholm\Psr7\Uri;
use Spiral\Cqrs\Attribute\QueryHandler;
use Spiral\Cqrs\QueryBusInterface;
use Spiral\Exceptions\ExceptionReporterInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class GetMetricsHandler
{
    public function __construct(
        private readonly QueryBusInterface $queryBus,
        private readonly HttpClientInterface $client,
        private readonly ServersRegistryInterface $registry,
        private readonly Parser $parser,
        private readonly ExceptionReporterInterface $reporter
    ) {
    }

    #[QueryHandler]
    public function handle(GetMetricsQuery $query): array
    {
        $server = $this->registry->getServerAddress($query->server);

        try {
            $config = $this->queryBus->ask(new GetConfigQuery($query->server));

            if (!isset($config['metrics']['address'])) {
                return [];
            }

            $scheme = isset($config['http']['ssl']) ? 'https' : 'http';

            $host  = (new Uri($config['metrics']['address']))
                ->withHost($server->getHost())
                ->withScheme($scheme);

            $response = $this->client->request('GET', (string)$host);
            $metricsData = \trim($response->getContent());

            return \iterator_to_array($this->parser->parse($metricsData));
        } catch (\Throwable $e) {
            $this->reporter->report($e);
            return [];
        }
    }
}
