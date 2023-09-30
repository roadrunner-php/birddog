<?php

declare(strict_types=1);

namespace App\Interfaces\HTTP\Resource\v1\Server;

use App\Application\HTTP\Response\JsonResource;
use App\Application\HTTP\Response\ResourceCollection;
use App\Infrastructure\RoadRunner\RPC\ValueObject\Server;

final class ServerResource extends JsonResource
{
    public function __construct(Server $server)
    {
        parent::__construct($server);
    }
}
