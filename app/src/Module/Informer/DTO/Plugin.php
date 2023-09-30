<?php

declare(strict_types=1);

namespace App\Module\Informer\DTO;

final readonly class Plugin implements \JsonSerializable, \Stringable
{
    /**
     * @param non-empty-string $name
     * @param Worker[] $workers
     */
    public function __construct(
        public string $name,
        public bool $isResettable,
        public array $workers,
    ) {
    }

    public function __toString(): string
    {
        return \json_encode($this->jsonSerialize());
    }

    public function jsonSerialize(): array
    {
        return [
            'name' => $this->name,
            'is_resettable' => $this->isResettable,
            'workers' => $this->workers,
        ];
    }
}
