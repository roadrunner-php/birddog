<?php

declare(strict_types=1);

namespace App\Interfaces\HTTP\Resource\v1\Service;

use App\Application\HTTP\Response\JsonResource;

class ServiceResource extends JsonResource
{
    protected function mapData(): array|\JsonSerializable
    {
        return [
            'name' => $this->data['name'],
            'statuses' => new StatusCollection($this->data['statuses']),
        ];
    }
}
