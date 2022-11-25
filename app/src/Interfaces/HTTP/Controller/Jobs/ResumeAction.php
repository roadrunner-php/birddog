<?php

declare(strict_types=1);

namespace App\Interfaces\HTTP\Controller\Jobs;

use App\Application\Command\Jobs\ResumeCommand;
use Spiral\Cqrs\CommandBusInterface;
use Spiral\Router\Annotation\Route;

final class ResumeAction
{
    #[Route('jobs/pipeline/resume', name: 'jobs.pipeline.resume', methods: 'POST')]
    public function __invoke(CommandBusInterface $bus, CommandRequest $request): array
    {
        $bus->dispatch(new ResumeCommand($request->server, $request->pipeline));

        return [
            'status' => true,
        ];
    }
}
