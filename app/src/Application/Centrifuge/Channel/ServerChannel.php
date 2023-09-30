<?php

declare(strict_types=1);

namespace App\Application\Centrifuge\Channel;

final readonly class ServerChannel extends Channel
{
    /**
     * @param non-empty-string $server
     */
    public function __construct(string $server)
    {
        parent::__construct(\sprintf('server.%s', $server));
    }
}
