<?php

declare(strict_types=1);

namespace App\Application\Bootloader;

use Spiral\Boot\Bootloader\Bootloader;
use Spiral\Exceptions\ExceptionHandler;
use Spiral\Exceptions\Reporter\FileReporter;
use Spiral\Exceptions\Reporter\LoggerReporter;
use Spiral\Http\ErrorHandler\PlainRenderer;
use Spiral\Http\ErrorHandler\RendererInterface;
use Spiral\Http\Middleware\ErrorHandlerMiddleware\EnvSuppressErrors;
use Spiral\Http\Middleware\ErrorHandlerMiddleware\SuppressErrorsInterface;

final class ExceptionHandlerBootloader extends Bootloader
{
    public function defineBindings(): array
    {
        return [
            SuppressErrorsInterface::class => EnvSuppressErrors::class,
            RendererInterface::class => PlainRenderer::class,
        ];
    }

    public function boot(
        ExceptionHandler $handler,
        LoggerReporter $logger,
        FileReporter $files
    ): void {
        $handler->addReporter($logger);
        $handler->addReporter($files);
    }
}
