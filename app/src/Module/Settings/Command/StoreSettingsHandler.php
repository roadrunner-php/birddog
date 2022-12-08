<?php

declare(strict_types=1);

namespace App\Module\Settings\Command;

use App\Application\Command\Settings\StoreCommand;
use App\Module\Settings\SettingsRepositoryInterface;
use Spiral\Cqrs\Attribute\CommandHandler;

final class StoreSettingsHandler
{
    public function __construct(
        private readonly SettingsRepositoryInterface $repository,
    ) {
    }

    #[CommandHandler]
    public function __invoke(StoreCommand $command): void
    {
        $this->repository->store($command->settings);
    }
}
