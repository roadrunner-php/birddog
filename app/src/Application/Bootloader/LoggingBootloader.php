<?php

declare(strict_types=1);

namespace App\Application\Bootloader;

use App\Application\AppDirectories;
use Monolog\Logger;
use Spiral\Boot\Bootloader\Bootloader;
use Spiral\Http\Middleware\ErrorHandlerMiddleware;
use Spiral\Monolog\Bootloader\MonologBootloader;
use Spiral\Monolog\Config\MonologConfig;

class LoggingBootloader extends Bootloader
{
    public function init(MonologBootloader $monolog, AppDirectories $dirs): void
    {
        // http level errors
        $monolog->addHandler(
            channel: ErrorHandlerMiddleware::class,
            handler: $monolog->logRotate(
                filename: $dirs->getRuntime('logs/http.log')
            )
        );

        // app level errors
        $monolog->addHandler(
            channel: MonologConfig::DEFAULT_CHANNEL,
            handler: $monolog->logRotate(
                filename: $dirs->getRuntime('logs/error.log'),
                level: Logger::ERROR,
                maxFiles: 25,
                bubble: false
            )
        );

        // debug and info messages via global LoggerInterface
        $monolog->addHandler(
            channel: MonologConfig::DEFAULT_CHANNEL,
            handler: $monolog->logRotate(
                filename: $dirs->getRuntime('logs/debug.log')
            )
        );
    }
}
