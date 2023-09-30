<?php

declare(strict_types=1);

namespace App\Interfaces\HTTP\Resource\v1\Metrics;

use App\Application\HTTP\Response\ResourceCollection;

final class MetricsCollection extends ResourceCollection
{
    protected function getData(): iterable
    {
        return (array)($this->data['metrics'] ?? []);
    }

    protected function wrapData(array $data): array
    {
        $data = parent::wrapData($data);

        $data['meta']['metrics'] = [
            'start' => $this->data['start'],
            'end' => $this->data['end'],
        ];

        $data['meta']['server'] = $this->data['server'];

        return $data;
    }
}
