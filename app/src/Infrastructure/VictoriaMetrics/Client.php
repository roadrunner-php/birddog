<?php

declare(strict_types=1);

namespace App\Infrastructure\VictoriaMetrics;

use App\Infrastructure\VictoriaMetrics\Exception\ResponseException;
use App\Infrastructure\VictoriaMetrics\Payload\Metric;
use App\Infrastructure\VictoriaMetrics\Payload\Point;
use App\Infrastructure\VictoriaMetrics\Payload\Range;
use App\Infrastructure\VictoriaMetrics\Payload\Series;
use App\Infrastructure\VictoriaMetrics\Payload\Tag;
use App\Infrastructure\VictoriaMetrics\Payload\Value;
use Carbon\Carbon;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class Client implements ClientInterface
{
    public function __construct(
        private readonly HttpClientInterface $writeClient,
        private readonly HttpClientInterface $queryClient,
    ) {
    }

    public function put(PointInterface ...$point): void
    {
        $this->writeClient->request('POST', '/api/put', [
            'body' => \json_encode($point),
        ]);
    }

    public function series(
        array $tags,
        \DateTimeInterface $start = new Carbon('-5 minutes'),
        \DateTimeInterface $end = new Carbon(),
    ): Series {
        $labels = '';
        if ($tags !== []) {
            $labels .= '{' . \implode(
                ',',
                \array_map(fn(Tag $tag) => \sprintf('%s="%s"', $tag->name, $tag->value), $tags)
            ) . '}';
        }

        $query = \http_build_query([
            'start' => $start->getTimestamp(),
            'end' => $end->getTimestamp(),
        ]);

        $response = $this->send('GET', 'api/v1/series?match[]=' . $labels . '&' . $query, []);

        $metrics = [];
        foreach ($response as $metric) {
            if (!isset($metrics[$metric['__name__']])) {
                $metrics[$metric['__name__']] = [
                    'name' => $metric['__name__'],
                    'tags' => [],
                    'type' => 'summary',
                ];
            }

            foreach ($metric as $key => $value) {
                if ($key === '__name__' || $key === 'server') {
                    continue;
                }

                if ($key === 'type') {
                    $metrics[$metric['__name__']]['type'] = $value;
                    continue;
                }

                $metrics[$metric['__name__']]['tags']["$key=$value"] = new Tag($key, $value);
            }
        }

        return new Series(
            \array_values(
                \array_map(fn(array $metric): Metric => new Metric(
                    name: $metric['name'],
                    type: $metric['type'],
                    tags: \array_values($metric['tags']),
                ), $metrics)
            ), $start, $end
        );
    }

    public function query(string $metric, ?string $step = null, array $tags = [],): array
    {
        if ($tags !== []) {
            $metric .= '{' . \implode(
                    ',',
                    \array_map(fn(Tag $tag) => \sprintf('%s="%s"', $tag->name, $tag->value), $tags)
                ) . '}';
        }

        $query = [
            'query' => $metric,
        ];

        if ($step !== null) {
            $query['step'] = $step;
        }

        $response = $this->send('GET', 'api/v1/query', $query);

        if (!isset($response['result'][0])) {
            return null;
        }

        $points = [];

        foreach ($response['result'] as $metric) {
            $points[] = new Point(
                metric: $metric['metric']['__name__'],
                value: \ctype_digit($metric['value'][1]) ? (int)$metric['value'][1] : (float)$metric['value'][1],
                tags: $tags
            );
        }

        return $points;
    }

    public function queryRange(
        string $metric,
        float $step = 5,
        \DateTimeInterface $start = new Carbon('-30 minutes'),
        \DateTimeInterface $end = new Carbon(),
        array $tags = [],
    ): Range {
        if ($tags !== []) {
            $metric .= '{' . \implode(
                    ',',
                    \array_map(fn(Tag $tag) => \sprintf('%s="%s"', $tag->name, $tag->value), $tags)
                ) . '}';
        }

        $query = [
            'query' => $metric,
            'step' => $step,
            'start' => $start->getTimestamp(),
            'end' => $end->getTimestamp(),
        ];

        $response = $this->send('GET', 'api/v1/query_range', $query);

        $values = [];
        if (isset($response['result'][0]['values'])) {
            $values = \array_map(
                fn(array $value) => new Value(
                    Carbon::createFromTimestamp($value[0]),
                    \ctype_digit($value[1]) ? (int)$value[1] : (float)$value[1],
                ),
                $response['result'][0]['values']
            );
        }

        return new Range($values, $start, $end);
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     * @throws \JsonException
     * @throws ResponseException
     */
    private function send(string $method, string $uri, array $query): array
    {
        $response = $this->queryClient->request(\strtoupper($method), $uri, [
            'query' => $query,
        ]);

        $response = \json_decode(
            json: $response->getContent(),
            associative: true,
            flags: JSON_THROW_ON_ERROR
        );

        if ($response['status'] !== 'success') {
            throw new ResponseException('Query failed');
        }

        return (array)$response['data'];
    }
}
