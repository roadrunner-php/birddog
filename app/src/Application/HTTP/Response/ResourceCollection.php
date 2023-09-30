<?php

declare(strict_types=1);

namespace App\Application\HTTP\Response;

use Psr\Http\Message\ResponseInterface;
use Spiral\DataGrid\GridInterface;
use Spiral\Http\Traits\JsonTrait;

class ResourceCollection implements ResourceInterface
{
    use JsonTrait;

    private readonly array $args;

    /**
     * @param class-string<ResourceInterface>|\Closure $resource
     */
    public function __construct(
        protected readonly iterable $data,
        protected string|\Closure $resource = JsonResource::class,
        mixed ...$args
    ) {
        $this->args = $args;
    }

    /**
     * @return class-string<ResourceInterface>|\Closure
     */
    protected function getResource(): string|\Closure
    {
        return $this->resource;
    }

    protected function getData(): iterable
    {
        return $this->data;
    }

    public function jsonSerialize(): array
    {
        $data = [];
        $resource = $this->getResource();

        foreach ($this->getData() as $key => $row) {
            if (\is_string($resource)) {
                $resource = static fn(mixed $row, mixed ...$args): ResourceInterface => new $resource($row, ...$args);
            } elseif (!\is_callable($resource) && $row instanceof \JsonSerializable) {
                $data[$key] = $row;
                continue;
            }

            $data[$key] = $resource($row, ...$this->args);
        }

        return $this->wrapData($data);
    }

    public function toResponse(ResponseInterface $response): ResponseInterface
    {
        return $this->writeJson($response, $this);
    }

    protected function wrapData(array $data): array
    {
        $grid = [];

        if ($this->data instanceof GridInterface) {
            foreach ([GridInterface::FILTERS, GridInterface::SORTERS] as $key) {
                $grid[$key] = $this->data->getOption($key);
            }
        }

        return [
            'data' => $data,
            'meta' => [
                'grid' => $grid,
            ],
        ];
    }

    public function __toString(): string
    {
        return \json_encode($this->jsonSerialize(), \JSON_THROW_ON_ERROR);
    }
}
