<?php

declare(strict_types=1);

namespace App\Application\Centrifuge\Channel;

final readonly class PublicChannel extends Channel
{
    public function __construct()
    {
        parent::__construct('public');
    }
}
