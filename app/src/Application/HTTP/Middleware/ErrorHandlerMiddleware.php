<?php

declare(strict_types=1);

namespace App\Application\HTTP\Middleware;

use App\Application\HTTP\Response\ErrorResource;
use App\Application\HTTP\Response\ValidationResource;
use App\Domain\Common\Exception\EntityNotFoundException;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface as Handler;
use Spiral\Core\Exception\ControllerException;
use Spiral\Exceptions\ExceptionHandlerInterface;
use Spiral\Exceptions\Verbosity;
use Spiral\Filters\Exception\ValidationException;
use Spiral\Goridge\RPC\Exception\ServiceException;
use Spiral\Http\ErrorHandler\RendererInterface;
use Spiral\Http\Exception\ClientException;
use Spiral\Http\Exception\ClientException\ForbiddenException;
use Spiral\Http\Exception\ClientException\NotFoundException;
use Spiral\Http\Exception\ClientException\UnauthorizedException;
use Spiral\Http\Middleware\ErrorHandlerMiddleware\SuppressErrorsInterface;
use Spiral\Logger\Traits\LoggerTrait;
use Spiral\RoadRunner\Jobs\Exception\JobsException;

final class ErrorHandlerMiddleware implements MiddlewareInterface
{
    use LoggerTrait;

    public function __construct(
        private readonly SuppressErrorsInterface $suppressErrors,
        private readonly RendererInterface $renderer,
        private readonly ResponseFactoryInterface $responseFactory,
        private readonly ExceptionHandlerInterface $errorHandler,
        private readonly Verbosity $verbosity = Verbosity::VERBOSE,
    ) {
    }

    /**
     * @psalm-suppress UnusedVariable
     * @throws \Throwable
     */
    public function process(Request $request, Handler $handler): Response
    {
        try {
            return $handler->handle($request);
        } catch (\Throwable $exception) {
            $code = 500;

            if ($exception instanceof ValidationException) {
                $response = new ValidationResource($exception);
                $code = $exception->getCode();
            } elseif ($exception instanceof ControllerException || $exception instanceof ClientException) {
                $response = new ErrorResource(
                    match ($exception->getCode()) {
                        ClientException::BAD_DATA,
                        ClientException::NOT_FOUND,
                        ControllerException::BAD_ACTION,
                        ControllerException::NOT_FOUND => new NotFoundException('Not found', $exception),
                        ClientException::FORBIDDEN,
                        ControllerException::FORBIDDEN => new ForbiddenException('Forbidden', $exception),
                        ClientException::UNAUTHORIZED,
                        ControllerException::UNAUTHORIZED => new UnauthorizedException('Unauthorized', $exception),
                        default => new ErrorResource($exception),
                    },
                );
                $code = $exception->getCode();

                if ($code === 500) {
                    $this->errorHandler->report($exception);
                }
            } elseif ($exception instanceof JobsException) {
                if ($exception->getPrevious() instanceof ServiceException) {
                    $response = new ErrorResource($exception);
                } else {
                    throw $exception;
                }
            } else {
                $this->errorHandler->report($exception);
                $response = new ErrorResource($exception);
            }

            return $response->toResponse(
                $this->responseFactory->createResponse(),
            )->withStatus($code);
        }
    }
}
