<?php

declare(strict_types=1);

namespace App\Interfaces\Centrifuge;

use App\Application\Centrifuge\Channel\Channel;
use App\Application\Centrifuge\Channel\PublicChannel;
use App\Application\Centrifuge\Channel\ServerChannel;
use App\Domain\Server\Service\ServersRepositoryInterface;
use Psr\Container\ContainerInterface;
use RoadRunner\Centrifugo\Payload\ConnectResponse;
use RoadRunner\Centrifugo\Request;
use RoadRunner\Centrifugo\Request\RequestInterface;
use Spiral\RoadRunnerBridge\Centrifugo\ServiceInterface;

final readonly class ConnectService implements ServiceInterface
{
    public function __construct(
        private ContainerInterface $container,
    ) {
    }

    /**
     * @param Request\Connect $request
     */
    public function handle(RequestInterface $request): void
    {
        $servers = $this->container->get(ServersRepositoryInterface::class);

        $channels = [new PublicChannel()];

        foreach ($servers->getServers() as $server) {
            $channels[] = new ServerChannel($server->name);
        }

        try {
            $request->respond(
                new ConnectResponse(
                    user: (string)$request->getAttribute('user_id'),
                    channels: \array_map(
                        static fn (Channel $channel) => (string) $channel,
                        $channels,
                    )
                ),
            );
        } catch (\Throwable $e) {
            $request->error($e->getCode(), $e->getMessage());
        }
    }
}
