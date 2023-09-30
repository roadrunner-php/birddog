<?php

declare(strict_types=1);

namespace App\Application\Centrifuge\Channel;

readonly class Channel implements \Stringable
{
    public function __construct(
        public string $name,
    ) {
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
