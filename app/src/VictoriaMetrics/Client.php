<?php

declare(strict_types=1);

namespace App\VictoriaMetrics;

use App\VictoriaMetrics\Exception\ResponseException;
use Carbon\Carbon;
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
        ];

        $query['start'] = $start->getTimestamp();
        $query['end'] = $end->getTimestamp();

        $response = $this->send($query);

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

    private function send(array $query): array
    {
        $response = $this->queryClient->request('GET', 'api/v1/query_range', [
            'query' => $query,
        ]);

        $response = \json_decode($response->getContent(), true, 512, JSON_THROW_ON_ERROR);

        if ($response['status'] !== 'success') {
            throw new ResponseException('Query failed');
        }

        return $response['data'];
    }
}
