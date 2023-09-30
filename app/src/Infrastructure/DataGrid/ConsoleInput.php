<?php

declare(strict_types=1);

namespace App\Infrastructure\DataGrid;

use Spiral\DataGrid\InputInterface;

final class ConsoleInput implements InputInterface
{
    public function __construct(
        public array $input,
    ) {
    }

    public function withNamespace(string $namespace): InputInterface
    {
        return $this;
    }

    public function hasValue(string $option): bool
    {
        return isset($this->input[$option]);
    }

    public function getValue(string $option, mixed $default = null): mixed
    {
        return $this->input[$option] ?? $default;
    }
}
