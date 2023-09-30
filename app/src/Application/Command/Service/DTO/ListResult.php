<?php

declare(strict_types=1);

namespace App\Application\Command\Service\DTO;

final readonly class ListResult
{
    /**
     * @param non-empty-string[] $services
     */
    public function __construct(
        public string $server,
        public array $services,
    ) {
    }
}
