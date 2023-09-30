<?php

declare(strict_types=1);

namespace App\Interfaces\HTTP\Controller\v1\Jobs\Pipeline;

use App\Application\Command\Jobs\PauseCommand;
use App\Application\HTTP\Response\ResourceInterface;
use App\Application\HTTP\Response\StatusResource;
use App\Interfaces\HTTP\Filter\v1\Jobs\CommandRequest;
use Spiral\Cqrs\CommandBusInterface;
use Spiral\Router\Annotation\Route;

final class PauseAction
{
    #[Route('jobs/pipeline/pause', name: 'jobs.pipeline.pause', methods: 'POST')]
    public function __invoke(CommandBusInterface $bus, CommandRequest $request): ResourceInterface
    {
        $result = $bus->dispatch(new PauseCommand($request->server, $request->pipeline));

        return new StatusResource(status: $result->status);
    }
}
