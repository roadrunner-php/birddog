<?php

declare(strict_types=1);

namespace App\Module\Settings\Command;

use App\Application\Command\Settings\DTO\StoreResult;
use App\Application\Command\Settings\StoreCommand;
use App\Module\Settings\SettingsRepositoryInterface;
use Spiral\Cqrs\Attribute\CommandHandler;

final readonly class StoreSettingsHandler
{
    public function __construct(
        private SettingsRepositoryInterface $repository,
    ) {
    }

    #[CommandHandler]
    public function __invoke(StoreCommand $command): StoreResult
    {
        $this->repository->store($command->settings);

        return new StoreResult(status: true);
    }
}
