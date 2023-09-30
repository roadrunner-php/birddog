<?php

declare(strict_types=1);

namespace App\Interfaces\Centrifuge;

use RoadRunner\Centrifugo\Payload\SubscribeResponse;
use RoadRunner\Centrifugo\Request;
use RoadRunner\Centrifugo\Request\RequestInterface;
use Spiral\RoadRunnerBridge\Centrifugo\ServiceInterface;

final readonly class SubscribeService implements ServiceInterface
{
    /**
     * @param Request\Subscribe $request
     */
    public function handle(RequestInterface $request): void
    {
        try {
            $request->respond(
                new SubscribeResponse()
            );
        } catch (\Throwable $e) {
            $request->error($e->getCode(), $e->getMessage());
        }
    }
}
