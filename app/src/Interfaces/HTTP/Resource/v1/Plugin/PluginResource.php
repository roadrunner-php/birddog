<?php

declare(strict_types=1);

namespace App\Interfaces\HTTP\Resource\v1\Plugin;

use App\Application\HTTP\Response\JsonResource;
use App\Module\Informer\DTO\Plugin;

/**
 * @property-read Plugin $data
 */
class PluginResource extends JsonResource
{
    protected function mapData(): array|\JsonSerializable
    {
        return [
            'name' => $this->data['name'],
            'is_resettable' => $this->data['is_resettable'],
            'workers' => new WorkerCollection(
                $this->data['workers'],
                $this->data['name']
            ),
        ];
    }
}
