<?php

declare(strict_types=1);

namespace App\Interfaces\HTTP\Resource\v1\Server;

use App\Application\HTTP\Response\JsonResource;
use App\Application\HTTP\Response\ResourceCollection;

final class ServerCollection extends ResourceCollection
{
    public function __construct(array $servers, private readonly string $default)
    {
        parent::__construct($servers, ServerResource::class);
    }

    protected function wrapData(array $data): array
    {
        $data = parent::wrapData($data);
        $data['default'] = $this->default;

        return $data;
    }
}
