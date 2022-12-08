<?php

declare(strict_types=1);

namespace App\Interfaces\HTTP\Controller\Plugin;

use App\Application\HTTP\Response\ResourceCollection;

final class WorkerCollection extends ResourceCollection
{
    public function __construct(iterable $data)
    {
        parent::__construct($data, WorkerResource::class);
    }
}
