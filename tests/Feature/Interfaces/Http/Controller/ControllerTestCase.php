<?php

declare(strict_types=1);

namespace Tests\Feature\Interfaces\Http\Controller;

use App\Domain\Server\Service\ServersRepositoryInterface;
use App\Infrastructure\RoadRunner\RPC\RPCManagerInterface;
use Tests\App\Http\HttpFaker;
use Tests\App\RPC\RPCManagerFaker;
use Tests\TestCase;

abstract class ControllerTestCase extends TestCase
{
    protected HttpFaker $http;
    protected RPCManagerFaker $rpc;
    protected ServersRepositoryInterface|\Mockery\MockInterface $servers;

    protected function setUp(): void
    {
        parent::setUp();

        $this->rpc = new RPCManagerFaker(
            $this->mockContainer(RPCManagerInterface::class),
            $this->servers = $this->mockContainer(ServersRepositoryInterface::class)
        );

        $this->http = new HttpFaker($this->fakeHttp());
    }
}
