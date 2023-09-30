<?php

declare(strict_types=1);

namespace App\Interfaces\HTTP\Resource\v1\Plugin;

use App\Application\HTTP\Response\JsonResource;
use App\Module\Informer\DTO\Worker;

/**
 * @property-read Worker $data
 */
final class WorkerResource extends JsonResource
{
    public function __construct(Worker $data, private readonly string $plugin)
    {
        parent::__construct($data);
    }

    protected function mapData(): array|\JsonSerializable
    {
        return [
            'plugin' => $this->plugin,
            ...$this->data->jsonSerialize(),
        ];
    }
}
