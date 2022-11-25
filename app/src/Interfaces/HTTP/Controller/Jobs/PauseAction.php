<?php

declare(strict_types=1);

namespace App\Interfaces\HTTP\Controller\Jobs;

use App\Application\Command\Jobs\PauseCommand;
use Spiral\Cqrs\CommandBusInterface;
use Spiral\Router\Annotation\Route;

final class PauseAction
{
    #[Route('jobs/pipeline/pause', name: 'jobs.pipeline.pause', methods: 'POST')]
    public function __invoke(CommandBusInterface $bus, CommandRequest $request): array
    {
        $bus->dispatch(new PauseCommand($request->server, $request->pipeline));

        return [
            'status' => true,
        ];
    }
}
