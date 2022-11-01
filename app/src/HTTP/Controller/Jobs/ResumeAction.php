<?php

declare(strict_types=1);

namespace App\HTTP\Controller\Jobs;

use App\CQRS\Command\Jobs\ResumeCommand;
use App\HTTP\Request\Jobs\CommandRequest;
use Spiral\Cqrs\CommandBusInterface;
use Spiral\Router\Annotation\Route;

final class ResumeAction
{
    #[Route('/jobs/pipeline/resume', name: 'api.jobs.pipeline.resume', methods: 'POST')]
    public function __invoke(CommandBusInterface $bus, CommandRequest $request): array
    {
        $bus->dispatch(new ResumeCommand($request->server, $request->pipeline));

        return [
            'status' => true,
        ];
    }
}
