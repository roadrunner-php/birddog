<?php

declare(strict_types=1);

namespace tests\Feature\Interfaces\Http\Controller\v1\Jobs\Pipeline;

use RoadRunner\Jobs\DTO\V1\Pipelines;
use Tests\Feature\Interfaces\Http\Controller\ControllerTestCase;

final class ResumeActionTest extends ControllerTestCase
{
    public function testResumePipeline(): void
    {
        $this->rpc
            ->withRegisteredServers('foo')
            ->shouldConnect('foo')
            ->assertCall('jobs.Resume',
                \Mockery::on(function (Pipelines $pipelines) {
                    $this->assertSame(['bar'], \iterator_to_array($pipelines->getPipelines()));

                    return true;
                }),
            );

        $this->http
            ->resumeJobPipeline(server: 'foo', pipeline: 'bar')
            ->assertStatusResource();
    }

    public function testServerIsRequired(): void
    {
        $this->rpc->withRegisteredServers('foo');

        $this->http
            ->resumeJobPipeline(server: null, pipeline: 'bar')
            ->assertValidationErrors([
                'server' => 'This value is required.',
            ]);
    }

    public function testPipelineIsRequired(): void
    {
        $this->rpc->withRegisteredServers('foo');

        $this->http
            ->resumeJobPipeline(server: 'bar', pipeline: null)
            ->assertValidationErrors([
                'pipeline' => 'This value is required.',
            ]);
    }
}
