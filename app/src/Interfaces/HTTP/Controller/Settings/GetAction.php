<?php

declare(strict_types=1);

namespace App\Interfaces\HTTP\Controller\Settings;

use App\Application\Command\Settings\GetQuery;
use Spiral\Cqrs\QueryBusInterface;
use Spiral\Router\Annotation\Route;

final class GetAction
{
    #[Route('settings', name: 'settings.get', methods: 'GET')]
    public function __invoke(QueryBusInterface $bus): array
    {
        return [
            'settings' => $bus->ask(new GetQuery()),
        ];
    }
}
