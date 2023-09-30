<?php

declare(strict_types=1);

namespace App\Application\HTTP\Response;

use Spiral\Core\Exception\ControllerException;
use Spiral\Http\Exception\ClientException;
use Spiral\Http\Traits\JsonTrait;

/**
 * @property-read \Throwable $data
 */
final class ErrorResource extends JsonResource
{
    use JsonTrait;

    public function __construct(\Throwable $data)
    {
        parent::__construct($data);
    }

    protected function mapData(): array|\JsonSerializable
    {
        return [
            'message' => $this->data->getMessage(),
            'code' => $this->getCode(),
        ];
    }

    protected function getCode(): int
    {
        return match (true) {
            $this->data instanceof ControllerException => $this->data->getCode(),
            $this->data instanceof ClientException => $this->data->getCode(),
            default => 500,
        };
    }
}
