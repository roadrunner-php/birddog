<?php

declare(strict_types=1);

namespace App\Application\Command\Settings;

use App\Application\Command\Settings\DTO\StoreResult;
use Spiral\Cqrs\CommandInterface;

/**
 * @implements CommandInterface<StoreResult>
 */
final readonly class StoreCommand implements CommandInterface
{
    public function __construct(
        public array $settings,
    ) {
    }
}
