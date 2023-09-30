<?php

declare(strict_types=1);

namespace App\Interfaces\HTTP\Controller\v1\Settings;

use App\Application\Command\Settings\GetQuery;
use App\Application\HTTP\Response\JsonResource;
use App\Application\HTTP\Response\ResourceInterface;
use Spiral\Cqrs\QueryBusInterface;
use Spiral\Router\Annotation\Route;

final class GetAction
{
    #[Route('settings', name: 'settings.get', methods: 'GET')]
    public function __invoke(QueryBusInterface $bus): ResourceInterface
    {
        return new JsonResource([
            'data' => $bus->ask(new GetQuery()),
        ]);
    }
}
