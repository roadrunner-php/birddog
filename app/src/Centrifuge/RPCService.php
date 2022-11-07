<?php

declare(strict_types=1);

namespace App\Centrifuge;

use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;
use RoadRunner\Centrifugo\Payload\RPCResponse;
use RoadRunner\Centrifugo\RequestInterface;
use RoadRunner\Centrifugo\RPCRequest;
use Spiral\Filters\Exception\ValidationException;
use Spiral\Http\Http;
use Spiral\RoadRunnerBridge\Centrifugo\ServiceInterface;

final class RPCService implements ServiceInterface
{
    public function __construct(
        private readonly Http $http,
        private readonly ServerRequestFactoryInterface $requestFactory,
    ) {
    }

    /**
     * @param RPCRequest $request
     */
    public function handle(RequestInterface $request): void
    {
        try {
            $response = $this->http->handle(
                $this->createHttpRequest($request)
            );

            $result = \json_decode((string)$response->getBody(), true);
            $result['code'] = $response->getStatusCode();
        } catch (ValidationException $e) {
            $result['code'] = $e->getCode();
            $result['errors'] = $e->errors;
            $result['message'] = $e->getMessage();
        } catch (\Throwable $e) {
            $result['code'] = $e->getCode();
            $result['message'] = $e->getMessage();
        }

        try {
            $request->respond(
                new RPCResponse(
                    data: $result
                )
            );
        } catch (\Throwable $e) {
            $request->error($e->getCode(), $e->getMessage());
        }
    }

    public function createHttpRequest(RPCRequest $request): ServerRequestInterface
    {
        [$method, $uri] = \explode(':', $request->method, 2);
        $method = \strtoupper($method);

        $httpRequest = $this->requestFactory->createServerRequest(\strtoupper($method), $uri)
            ->withHeader('Content-Type', 'application/json');

//        foreach ($request->headers as $key => $headers) {
//            $httpRequest = $httpRequest->withHeader($key, $headers);
//        }

        return match ($method) {
            'GET', 'HEAD' => $httpRequest->withQueryParams($request->data),
            'POST', 'PUT', 'DELETE' => $httpRequest->withParsedBody($request->data),
            default => throw new \InvalidArgumentException('Unsupported method'),
        };
    }
}
