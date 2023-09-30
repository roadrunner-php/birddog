<?php

declare(strict_types=1);

namespace App\Application\Command\Service;

use App\Application\Command\Service\DTO\ListResult;
use Spiral\Cqrs\QueryInterface;

/**
 * @implements QueryInterface<ListResult>
 */
final readonly class ListQuery implements QueryInterface
{
    public function __construct(
        public string $server,
    ) {
    }
}
