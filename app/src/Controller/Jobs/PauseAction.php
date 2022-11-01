<?php

declare(strict_types=1);

namespace App\Controller\Jobs;

use App\CQRS\Command\Jobs\PauseCommand;
use App\HTTP\Request\Jobs\CommandRequest;
use Spiral\Cqrs\CommandBusInterface;
use Spiral\Router\Annotation\Route;

final class PauseAction
{
    #[Route('/jobs/pipeline/pause', name: 'api.jobs.pipeline.pause', methods: 'POST')]
    public function __invoke(CommandBusInterface $bus, CommandRequest $request): array
    {
        $bus->dispatch(new PauseCommand($request->server, $request->pipeline));

        return [
            'status' => true,
        ];
    }
}
