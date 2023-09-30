<?php

declare(strict_types=1);

namespace tests\Feature\Interfaces\Http\Controller\v1\Jobs\Pipeline;

use RoadRunner\Jobs\DTO\V1\Pipelines;
use Tests\Feature\Interfaces\Http\Controller\ControllerTestCase;

final class PauseActionTest extends ControllerTestCase
{
    public function testPausePipeline(): void
    {
        $this->rpc
            ->withRegisteredServers('foo')
            ->shouldConnect('foo')
            ->assertCall('jobs.Pause',
                \Mockery::on(function (Pipelines $pipelines) {
                    $this->assertSame(['bar'], \iterator_to_array($pipelines->getPipelines()));

                    return true;
                }),
            );

        $this->http
            ->pauseJobPipeline(server: 'foo', pipeline: 'bar')
            ->assertStatusResource();
    }

    public function testServerIsRequired(): void
    {
        $this->rpc->withRegisteredServers('foo');

        $this->http
            ->pauseJobPipeline(server: null, pipeline: 'bar')
            ->assertValidationErrors([
                'server' => 'This value is required.',
            ]);
    }

    public function testPipelineIsRequired(): void
    {
        $this->rpc->withRegisteredServers('foo');

        $this->http
            ->pauseJobPipeline(server: 'bar', pipeline: null)
            ->assertValidationErrors([
                'pipeline' => 'This value is required.',
            ]);
    }
}
