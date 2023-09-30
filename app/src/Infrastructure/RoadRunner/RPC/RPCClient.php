<?php

declare(strict_types=1);

namespace App\Infrastructure\RoadRunner\RPC;

use App\Infrastructure\RoadRunner\RPC\ValueObject\Server;
use RoadRunner\Jobs\DTO\V1\Pipelines;
use RoadRunner\Jobs\DTO\V1\Stats;
use Spiral\Goridge\RPC\Codec\JsonCodec;
use Spiral\Goridge\RPC\Codec\ProtobufCodec;
use Spiral\Goridge\RPC\RPCInterface;
use Spiral\RoadRunner\Jobs\Jobs;
use Spiral\RoadRunner\Jobs\Queue;

/**
 * @psalm-type TPluginName = non-empty-string
 * @psalm-type TPluginWorker = array{
 *     CPUPercent: float,
 *     command: string,
 *     created: int,
 *     memoryUsage: int,
 *     pid: int,
 *     numExecs: int,
 *     status: int,
 *     statusStr: non-empty-string
 * }
 *
 * @psalm-type TQueuePipeline = array{
 *     pipeline: non-empty-string,
 *     driver: non-empty-string,
 *     queue: non-empty-string,
 *     priority: int,
 *     active: int,
 *     delayed: int,
 *     reserved: int,
 *     ready: bool
 * }
 *
 * @mixin RPCInterface
 */
final class RPCClient
{
    public function __construct(
        private RPCInterface $rpc,
        public readonly Server $server,
    ) {
    }

    /**
     * Get RoadRunner server config.
     */
    public function getConfig(): array
    {
        $config = $this
            ->withJsonCodec()
            ->call('rpc.Config', true);

        return \json_decode(\base64_decode($config), true);
    }

    /**
     * Get RoadRunner server version.
     *
     * @return non-empty-string
     */
    public function getVersion(): string
    {
        return (string)$this
            ->withJsonCodec()
            ->call('rpc.Version', true);
    }

    /**
     * Send add worker signal to given plugin.
     *
     * @param TPluginName $plugin
     */
    public function addWorker(string $plugin): void
    {
        $this->withJsonCodec()
            ->call('informer.AddWorker', $plugin);
    }

    /**
     * Send remove worker signal to given plugin.
     *
     * @param TPluginName $plugin
     */
    public function removeWorker(string $plugin): void
    {
        $this->withJsonCodec()
            ->call('informer.RemoveWorker', $plugin);
    }

    /**
     * Get list of plugins available for given server.
     *
     * @return array<TPluginName>
     */
    public function pluginList(): array
    {
        return (array)$this
            ->withJsonCodec()
            ->call('informer.List', null);
    }

    /**
     * Get list of plugins that can be reset (Workers can be reset) for given server.
     *
     * @return array<TPluginName>
     */
    public function resettablePluginList(): array
    {
        return (array)$this
            ->withJsonCodec()
            ->call('resetter.List', null);
    }

    /**
     * Send reset signal to all workers for given plugin.
     *
     * @param TPluginName $plugin
     */
    public function resetPlugin(string $plugin): bool
    {
        return (bool)$this
            ->withJsonCodec()
            ->call('resetter.Reset', $plugin);
    }

    /**
     * Get list of worker pool for given plugin.
     *
     * @param TPluginName $plugin
     *
     * @return TPluginWorker[]
     */
    public function pluginWorkers(string $plugin): array
    {
        $result = (array)$this
            ->withJsonCodec()
            ->call('informer.Workers', $plugin);

        return $result['workers'] ?? [];
    }

    /**
     * Send close signal to given TCP connection.
     *
     * @param non-empty-string $connectionUuid
     */
    public function closeTcpConnection(string $connectionUuid): bool
    {
        return (bool)$this
            ->withJsonCodec()
            ->call('tcp.Close', $connectionUuid);
    }

    /**
     * Send pause signal to given Queue pipeline.
     *
     * @param non-empty-string $pipeline
     */
    public function pauseQueuePipeline(string $pipeline): void
    {
        $this->withProtobufCodec()->call(
            'jobs.Pause',
            new Pipelines([
                'pipelines' => [$pipeline],
            ]),
        );
    }

    /**
     * Send resume signal to given Queue pipeline.
     *
     * @param non-empty-string $pipeline
     */
    public function resumeQueuePipeline(string $pipeline): void
    {
        $this->withProtobufCodec()->call(
            'jobs.Resume',
            new Pipelines([
                'pipelines' => [$pipeline],
            ]),
        );
    }

    /**
     * Get list of declared Queue pipelines.
     *
     * @return TQueuePipeline[]
     */
    public function queuePipelineList(): array
    {
        $stats = $this
            ->withProtobufCodec()
            ->call('jobs.Stat', '', Stats::class);

        $pipelines = [];

        foreach ($stats->getStats() as $stat) {
            $pipelines[] = [
                'pipeline' => $stat->getPipeline(),
                'driver' => $stat->getDriver(),
                'queue' => $stat->getQueue(),
                'priority' => $stat->getPriority(),
                'active' => $stat->getActive(),
                'delayed' => $stat->getDelayed(),
                'reserved' => $stat->getReserved(),
                'ready' => $stat->getReady(),
            ];
        }

        return $pipelines;
    }

    /**
     * Invoke remove RoadRunner service method using given payload (free form).
     *
     * @param non-empty-string $method
     */
    public function call(string $method, mixed $payload, mixed $options = null): mixed
    {
        return $this->rpc->call($method, $payload, $options);
    }

    public function withJsonCodec(): self
    {
        $self = clone $this;
        $self->rpc = $self->rpc->withCodec(new JsonCodec());

        return $self;
    }

    public function withProtobufCodec(): self
    {
        $self = clone $this;
        $self->rpc = $self->rpc->withCodec(new ProtobufCodec());

        return $self;
    }

    public function getRpc(): RPCInterface
    {
        return $this->rpc;
    }
}
