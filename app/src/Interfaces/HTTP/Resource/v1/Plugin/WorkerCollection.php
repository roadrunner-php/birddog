<?php

declare(strict_types=1);

namespace App\Interfaces\HTTP\Resource\v1\Plugin;

use App\Application\HTTP\Response\ResourceCollection;

final class WorkerCollection extends ResourceCollection
{
    public function __construct(iterable $data, string $plugin)
    {
        parent::__construct($data, WorkerResource::class, $plugin);
    }
}
