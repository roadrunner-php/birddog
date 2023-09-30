<?php

declare(strict_types=1);

namespace Unit\Infrastructure\RoadRunner\RPC;

use App\Infrastructure\RoadRunner\RPC\RPCClient;
use App\Infrastructure\RoadRunner\RPC\ValueObject\Server;
use Mockery as m;
use RoadRunner\Jobs\DTO\V1\Pipelines;
use RoadRunner\Jobs\DTO\V1\Stat;
use RoadRunner\Jobs\DTO\V1\Stats;
use Spiral\Goridge\RPC\RPCInterface;
use Tests\App\RPC\RPCFaker;
use Tests\TestCase;

final class RPCClientTest extends TestCase
{
    private RPCClient $client;
    private RPCFaker $rpc;

    protected function setUp(): void
    {
        parent::setUp();
        $this->rpc = new RPCFaker($rpc = $this->mockContainer(RPCInterface::class));

        $this->client = new RPCClient(
            rpc: $rpc,
            server: new Server(name: 'test', address: 'tcp://127.0.0.1:6001'),
        );
    }

    public function testGetConfig(): void
    {
        $this->rpc
            ->assertJsonCodec()
            ->assertCall('rpc.Config', true)
            ->andReturnConfig(['version' => 3]);

        $config = $this->client->getConfig();

        $this->assertSame(['version' => 3], $config);
    }

    public function testGetVersion(): void
    {
        $this->rpc
            ->assertJsonCodec()
            ->assertCall('rpc.Version', true)
            ->andReturnVersion(version: '1.0.0');

        $version = $this->client->getVersion();

        $this->assertSame('1.0.0', $version);
    }

    public function testAddWorker(): void
    {
        $this->rpc
            ->assertJsonCodec()
            ->assertCall('informer.AddWorker', 'http');

        $this->client->addWorker('http');
    }

    public function testRemoveWorker(): void
    {
        $this->rpc
            ->assertJsonCodec()
            ->assertCall('informer.RemoveWorker', 'tcp');

        $this->client->removeWorker('tcp');
    }

    public function testPluginList(): void
    {
        $this->rpc
            ->assertJsonCodec()
            ->assertCall('informer.List', null)
            ->andReturnPluginList($plugins = ['http', 'jobs', 'status']);

        $response = $this->client->pluginList();

        $this->assertSame($plugins, $response);
    }

    public function testResettablePluginList(): void
    {
        $this->rpc
            ->assertJsonCodec()
            ->assertCall('resetter.List', null)
            ->andReturnPluginList($plugins = ['http', 'jobs']);

        $response = $this->client->resettablePluginList();

        $this->assertSame($plugins, $response);
    }

    public function testResetPlugin(): void
    {
        $this->rpc
            ->assertJsonCodec()
            ->assertCall('resetter.Reset', 'jobs')
            ->andReturn(1);

        $response = $this->client->resetPlugin('jobs');

        $this->assertTrue($response);

        $this->rpc
            ->assertJsonCodec()
            ->assertCall('resetter.Reset', 'http')
            ->andReturn(0);

        $response = $this->client->resetPlugin('http');

        $this->assertFalse($response);
    }

    public function testPluginWorkers(): void
    {
        $this->rpc
            ->assertJsonCodec()
            ->assertCall('informer.Workers', 'jobs')
            ->andReturnWorkerList([
                'workers' => $workers = [
                    [
                        'pid' => 1,
                        'status' => 1,
                        'numExecs' => 0,
                        'created' => 1696064341713431870,
                        'memoryUsage' => 46551040,
                        'CPUPercent' => 0.068126334280511,
                        'command' => '',
                        "statusStr" => 'ready',
                    ],
                    [
                        'pid' => 2,
                        'status' => 2,
                        'numExecs' => 3,
                        'created' => 1696064341083670504,
                        'memoryUsage' => 49577984,
                        'CPUPercent' => 0.080640060408347,
                        'command' => '',
                        "statusStr" => 'working',
                    ],
                    [
                        'pid' => 3,
                        'status' => 1,
                        'numExecs' => 0,
                        'created' => 0,
                        'memoryUsage' => 51699712,
                        'CPUPercent' => 0.2586069315593,
                        'command' => '/usr/bin/npm run dev',
                        "statusStr" => '',
                    ],
                ],
            ]);

        $response = $this->client->pluginWorkers('jobs');
        $this->assertSame($workers, $response);
    }

    public function testCloseTcpConnection(): void
    {
        $this->rpc
            ->assertJsonCodec()
            ->assertCall('tcp.Close', 'connection-uuid');

        $this->client->closeTcpConnection('connection-uuid');
    }

    public function testQueuePipelineList(): void
    {
        $client = $this->rpc
            ->assertProtobufCodec();

        $client->assertCall('jobs.Stat', '', Stats::class)
            ->andReturnQueuePipelineList(
                new Stats([
                    'stats' => [
                        new Stat(
                            $pipeline = [
                                'pipeline' => 'local',
                                'driver' => 'memory',
                                'queue' => '',
                                'priority' => 1,
                                'active' => 1,
                                'delayed' => 0,
                                'reserved' => 1,
                                'ready' => true,
                            ],
                        ),
                    ],
                ]),
            );

        $result = $this->client->queuePipelineList();

        $this->assertSame([$pipeline], $result);
    }

    public function testPauseQueuePipeline(): void
    {
        $this->rpc
            ->assertProtobufCodec()
            ->assertCall(
                'jobs.Pause',
                m::on(function (Pipelines $pipelines) {
                    $this->assertSame(['foo'], \iterator_to_array($pipelines->getPipelines()));

                    return true;
                }),
            );

        $this->client->pauseQueuePipeline('foo');
    }

    public function testResumeQueuePipeline(): void
    {
        $this->rpc
            ->assertProtobufCodec()
            ->assertCall(
                'jobs.Resume',
                m::on(function (Pipelines $pipelines) {
                    $this->assertSame(['foo'], \iterator_to_array($pipelines->getPipelines()));

                    return true;
                }),
            );

        $this->client->resumeQueuePipeline('foo');
    }
}
