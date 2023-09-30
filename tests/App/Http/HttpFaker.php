<?php

declare(strict_types=1);

namespace Tests\App\Http;

use Carbon\Carbon;
use Spiral\Testing\Http\FakeHttp;
use Spiral\Testing\Http\TestResponse;

/**
 * @mixin FakeHttp
 */
final class HttpFaker
{
    private Carbon $date;
    private bool $dumpResponse = false;

    public function __construct(
        private FakeHttp $http,
    ) {
        $this->date = Carbon::create(2021, 1, 1, 0, 0, 0);
    }

    public function serviceRestart(?string $server, ?string $service): ResponseAssertions
    {
        return $this->makeResponse(
            $this->http->postJson('/api/v1/service/restart', [
                'server' => $server,
                'service' => $service,
            ]),
        );
    }

    public function serviceTerminate(?string $server, ?string $service): ResponseAssertions
    {
        return $this->makeResponse(
            $this->http->postJson('/api/v1/service/terminate', [
                'server' => $server,
                'service' => $service,
            ]),
        );
    }

    public function serviceStatus(?string $server, ?string $service): ResponseAssertions
    {
        return $this->makeResponse(
            $this->http->getJson('/api/v1/service/status', [
                'server' => $server,
                'service' => $service,
            ]),
        );
    }

    public function serviceList(?string $server): ResponseAssertions
    {
        return $this->makeResponse(
            $this->http->getJson('/api/v1/services', [
                'server' => $server,
            ]),
        );
    }

    public function settingsStore(array $settings = []): ResponseAssertions
    {
        return $this->makeResponse(
            $this->http->postJson('/api/v1/settings', [
                'settings' => $settings,
            ]),
        );
    }

    public function settingsList(): ResponseAssertions
    {
        return $this->makeResponse(
            $this->http->getJson('/api/v1/settings'),
        );
    }

    public function closeTcpConnection(?string $server, ?string $connectionUuid): ResponseAssertions
    {
        return $this->makeResponse(
            $this->http->postJson('/api/v1/tcp/close', [
                'server' => $server,
                'uuid' => $connectionUuid,
            ]),
        );
    }

    public function pauseJobPipeline(?string $server, ?string $pipeline): ResponseAssertions
    {
        return $this->makeResponse(
            $this->http->postJson('/api/v1/jobs/pipeline/pause', [
                'server' => $server,
                'pipeline' => $pipeline,
            ]),
        );
    }

    public function resumeJobPipeline(?string $server, ?string $pipeline): ResponseAssertions
    {
        return $this->makeResponse(
            $this->http->postJson('/api/v1/jobs/pipeline/resume', [
                'server' => $server,
                'pipeline' => $pipeline,
            ]),
        );
    }

    public function jobPipelineList(?string $server): ResponseAssertions
    {
        return $this->makeResponse(
            $this->http->getJson('/api/v1/jobs/pipelines', [
                'server' => $server,
            ]),
        );
    }

    public function getConfig(?string $server): ResponseAssertions
    {
        return $this->makeResponse(
            $this->http->getJson('/api/v1/server/config', [
                'server' => $server,
            ]),
        );
    }

    public function getVersion(?string $server): ResponseAssertions
    {
        return $this->makeResponse(
            $this->http->getJson('/api/v1/server/version', [
                'server' => $server,
            ]),
        );
    }

    public function listServers(): ResponseAssertions
    {
        return $this->makeResponse(
            $this->http->getJson('/api/v1/servers'),
        );
    }

    public function registerServer(?string $name, ?string $address): ResponseAssertions
    {
        return $this->makeResponse(
            $this->http->postJson('/api/v1/server', [
                'name' => $name,
                'address' => $address,
            ]),
        );
    }

    public function listPlugins(?string $server,): ResponseAssertions
    {
        return $this->makeResponse(
            $this->http->getJson('/api/v1/plugins', [
                'server' => $server,
            ]),
        );
    }

    public function listWorkers(
        ?string $server,
        ?string $plugin,
        ?array $filters = null,
        ?array $sort = null,
    ): ResponseAssertions {
        return $this->makeResponse(
            $this->http->getJson('/api/v1/plugin/workers', [
                'server' => $server,
                'plugin' => $plugin,
                'filters' => $filters,
                'sort' => $sort,
            ]),
        );
    }

    public function addWorker(?string $server, ?string $plugin): ResponseAssertions
    {
        return $this->makeResponse(
            $this->http->postJson('/api/v1/plugin/worker', [
                'server' => $server,
                'plugin' => $plugin,
            ]),
        );
    }

    public function removeWorker(?string $server, ?string $plugin): ResponseAssertions
    {
        return $this->makeResponse(
            $this->http->deleteJson('/api/v1/plugin/worker', [
                'server' => $server,
                'plugin' => $plugin,
            ]),
        );
    }

    public function currentDate(): Carbon
    {
        return $this->date;
    }

    public function freezeDate(): self
    {
        Carbon::setTestNow($this->date);

        return $this;
    }

    public function dumpResponse(): self
    {
        $self = clone $this;
        $self->dumpResponse = true;

        return $self;
    }

    public function __call(string $name, array $arguments): TestResponse
    {
        if (!method_exists($this->http, $name)) {
            throw new \Exception("Method $name does not exist");
        }

        return $this->http->$name(...$arguments);
    }

    private function makeResponse(TestResponse $response): ResponseAssertions
    {
        if ($this->dumpResponse) {
            dump((string)$response);
        }

        return new ResponseAssertions($response);
    }
}
