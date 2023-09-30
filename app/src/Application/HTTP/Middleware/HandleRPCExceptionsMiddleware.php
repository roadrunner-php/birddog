<?php

declare(strict_types=1);

namespace App\Application\HTTP\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Spiral\Goridge\RPC\Exception\ServiceException;
use Spiral\Http\ResponseWrapper;
use Spiral\RoadRunner\Jobs\Exception\JobsException;

final readonly class HandleRPCExceptionsMiddleware implements MiddlewareInterface
{
    public function __construct(
        private ResponseWrapper $wrapper
    ) {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            return $handler->handle($request);
        } catch (ServiceException $e) {
            return $this->getResponse($e);
        } catch (JobsException $e) {
            if ($e->getPrevious() instanceof ServiceException) {
                return $this->getResponse($e);
            }

            throw $e;
        }
    }

    public function getResponse(\Exception|JobsException $e): ResponseInterface
    {
        return $this->wrapper->json([
            'error' => $e->getMessage(),
            'code' => $e->getCode(),
        ], 500);
    }
}
