<?php

declare(strict_types=1);

namespace App\Module\Settings\Command;

use App\Application\Command\Settings\GetQuery;
use App\Module\Settings\SettingsRepositoryInterface;
use Spiral\Cqrs\Attribute\QueryHandler;

final readonly class GetSettingsHandler
{
    public function __construct(
        private SettingsRepositoryInterface $repository,
    ) {
    }

    #[QueryHandler]
    public function __invoke(GetQuery $query): array
    {
        return $this->repository->get();
    }
}
