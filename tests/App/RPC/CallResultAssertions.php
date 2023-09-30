<?php

declare(strict_types=1);

namespace Tests\App\RPC;

use Mockery\CompositeExpectation;
use RoadRunner\Jobs\DTO\V1\Stat;
use RoadRunner\Jobs\DTO\V1\Stats;

/**
 * @mixin RPCFaker
 * @mixin CompositeExpectation
 */
final readonly class CallResultAssertions
{
    public function __construct(
        private CompositeExpectation $expectation,
        private RPCFaker $faker,
    ) {
    }

    /**
     * Returns RoadRunner config as expectation result.
     */
    public function andReturnConfig(array $config = []): self
    {
        $this->expectation->andReturn(\base64_encode(\json_encode($config)));

        return $this;
    }

    public function andReturnVersion(string $version = '1.0.0'): self
    {
        $this->expectation->andReturn($version);

        return $this;
    }

    public function andReturnPluginList(array $list = ['http', 'jobs', 'grpc', 'temporal', 'status']): self
    {
        $this->expectation->andReturn($list);

        return $this;
    }

    public function andReturnWorkerList(?array $list = null): self
    {
        $list ??= [
            'workers' => [
                [
                    'pid' => 4,
                    'status' => 1,
                    'numExecs' => 0,
                    'created' => 1696064341713431870,
                    'memoryUsage' => 46551040,
                    'CPUPercent' => 0.068126334280511,
                    'command' => '',
                    "statusStr" => 'ready',
                ],
                [
                    'pid' => 3,
                    'status' => 2,
                    'numExecs' => 3,
                    'created' => 1696064341083670504,
                    'memoryUsage' => 49577984,
                    'CPUPercent' => 0.080640060408347,
                    'command' => '',
                    "statusStr" => 'working',
                ],
                [
                    'pid' => 1,
                    'status' => 1,
                    'numExecs' => 0,
                    'created' => 0,
                    'memoryUsage' => 51699712,
                    'CPUPercent' => 0.2586069315593,
                    'command' => '/usr/bin/npm run dev',
                    "statusStr" => '',
                ],
            ],
        ];

        $this->expectation->andReturn($list);

        return $this;
    }

    public function andReturnQueuePipelineList(?Stats $stats = null): self
    {
        $stats ??= new Stats([
            'stats' => [
                new Stat(
                    [
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
        ]);

        $this->expectation->andReturn($stats);

        return $this;
    }

    public function __call(string $name, array $arguments): self
    {
        if (method_exists($this->expectation, $name)) {
            $this->expectation->$name(...$arguments);
        } elseif(method_exists($this->faker, $name)) {
            $this->faker->$name(...$arguments);
        } else {
            throw new \Exception("Method $name does not exist");
        }

        return $this;
    }
}
