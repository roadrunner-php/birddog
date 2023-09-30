<?php

declare(strict_types=1);

namespace Tests\App\RPC;

use Spiral\Goridge\RPC\Codec\JsonCodec;
use Spiral\Goridge\RPC\Codec\ProtobufCodec;

final class RPCFaker
{
    public function __construct(
        private \Mockery\MockInterface $rpc,
    ) {
    }

    public function assertJsonCodec(): self
    {
        $this->rpc
            ->shouldReceive('withCodec')
            ->once()
            ->with(\Mockery::type(JsonCodec::class))
            ->andReturnSelf();

        return $this;
    }

    public function assertProtobufCodec(): self
    {
        $this->rpc
            ->shouldReceive('withCodec')
            ->once()
            ->with(\Mockery::type(ProtobufCodec::class))
            ->andReturnSelf();

        return $this;
    }

    public function assertCall(string $method, mixed $payload, mixed $options = null): CallResultAssertions
    {
        $ex = $this->rpc
            ->shouldReceive('call')
            ->once();

        return new CallResultAssertions(
            $ex->with($method, $payload, $options),
            $this,
        );
    }
}
