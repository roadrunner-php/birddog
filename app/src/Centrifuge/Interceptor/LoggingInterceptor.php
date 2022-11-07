<?php

declare(strict_types=1);

namespace App\Centrifuge\Interceptor;

use Psr\Log\LoggerInterface;
use Spiral\Core\CoreInterceptorInterface;
use Spiral\Core\CoreInterface;

final class LoggingInterceptor implements CoreInterceptorInterface
{
    public function __construct(
        private readonly LoggerInterface $logger,
    ) {
    }

    public function process(string $controller, string $action, array $parameters, CoreInterface $core): mixed
    {
        $this->logger->debug('Centrifuge request', [
            'controller' => $controller,
            'parameters' => $parameters,
        ]);

        return $core->callAction($controller, $action, $parameters);
    }
}
