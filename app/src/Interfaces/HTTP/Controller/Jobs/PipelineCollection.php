<?php

declare(strict_types=1);

namespace App\Interfaces\HTTP\Controller\Jobs;

use App\Application\HTTP\Response\ResourceCollection;

final class PipelineCollection extends ResourceCollection
{
    public function __construct(iterable $data)
    {
        parent::__construct($data, PipelineResource::class);
    }
}

