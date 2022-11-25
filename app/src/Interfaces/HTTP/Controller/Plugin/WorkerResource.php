<?php

declare(strict_types=1);

namespace App\Interfaces\HTTP\Controller\Plugin;

use App\Application\HTTP\Response\JsonResource;
use Psr\Http\Message\ServerRequestInterface;

final class WorkerResource extends JsonResource
{
    protected function mapData(ServerRequestInterface $request): array|\JsonSerializable
    {
        return $this->data;
    }
}
