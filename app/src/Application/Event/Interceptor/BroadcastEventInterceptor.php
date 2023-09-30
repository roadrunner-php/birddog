<?php

declare(strict_types=1);

namespace App\Application\Event\Interceptor;

use App\Application\Event\ShouldBroadcast;
use Psr\Container\ContainerInterface;
use Spiral\Broadcasting\BroadcastInterface;
use Spiral\Core\CoreInterceptorInterface;
use Spiral\Core\CoreInterface;
use Spiral\Serializer\SerializerRegistryInterface;

final readonly class BroadcastEventInterceptor implements CoreInterceptorInterface
{
    public function __construct(
        private ContainerInterface $container,
        private SerializerRegistryInterface $registry
    ) {
    }

    public function process(string $controller, string $action, array $parameters, CoreInterface $core): mixed
    {
        $broadcast = $this->container->get(BroadcastInterface::class);

        $event = $parameters['event'];
        $result = $core->callAction($controller, $action, $parameters);

        if ($event instanceof ShouldBroadcast) {
            // TODO Add exception handling
            $broadcast->publish(
                $event->getBroadcastTopics(),
                $this->registry->get('json')->serialize(
                    ['event' => $event->getEventName(), 'data' => $event->getPayload()]
                )
            );
        }

        return $result;
    }
}
