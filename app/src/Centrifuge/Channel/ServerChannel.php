<?php

declare(strict_types=1);

namespace App\Centrifuge\Channel;

final class ServerChannel extends Channel
{
    public function __construct(string $server)
    {
        parent::__construct(\sprintf('server.%s', $server));
    }
}
