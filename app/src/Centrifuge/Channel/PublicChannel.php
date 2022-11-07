<?php

declare(strict_types=1);

namespace App\Centrifuge\Channel;

final class PublicChannel extends Channel
{
    public function __construct()
    {
        parent::__construct('public');
    }
}
