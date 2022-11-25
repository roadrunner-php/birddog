<?php

declare(strict_types=1);

namespace App\Interfaces\HTTP\Controller\Plugin;

use App\Application\HTTP\Response\JsonResource;
use Psr\Http\Message\ServerRequestInterface;

class PluginResource extends JsonResource
{
    protected function mapData(ServerRequestInterface $request): array|\JsonSerializable
    {
        return [
            'name' => $this->data['name'],
            'is_ressetable' => $this->data['is_ressetable'],
            'workers' => (new WorkerCollection($this->data['workers']))->resolve($request),
        ];
    }
}
