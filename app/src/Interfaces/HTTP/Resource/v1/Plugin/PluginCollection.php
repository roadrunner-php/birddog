<?php

declare(strict_types=1);

namespace App\Interfaces\HTTP\Resource\v1\Plugin;

use App\Application\HTTP\Response\ResourceCollection;
use Spiral\DataGrid\GridInterface;

final class PluginCollection extends ResourceCollection
{
    public function __construct(GridInterface|iterable $data)
    {
        parent::__construct($data, PluginResource::class);
    }
}
