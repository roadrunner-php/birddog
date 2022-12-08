<?php

declare(strict_types=1);

namespace App\Application\Bootloader;

use App\Application\HTTP\Middleware\HandleRPCExceptionsMiddleware;
use Spiral\Bootloader\Http\RouterBootloader;
use Spiral\Bootloader\Http\RoutesBootloader as BaseRoutesBootloader;
use Spiral\Filter\ValidationHandlerMiddleware;
use Spiral\Http\Middleware\ErrorHandlerMiddleware;
use Spiral\Http\Middleware\JsonPayloadMiddleware;
use Spiral\Router\Bootloader\AnnotatedRoutesBootloader;
use Spiral\Router\GroupRegistry;

final class RoutesBootloader extends BaseRoutesBootloader
{
    protected const DEPENDENCIES = [
        RouterBootloader::class,
        AnnotatedRoutesBootloader::class,
    ];

    protected function globalMiddleware(): array
    {
        return [
            ErrorHandlerMiddleware::class,
            JsonPayloadMiddleware::class,
            ValidationHandlerMiddleware::class,
        ];
    }

    protected function middlewareGroups(): array
    {
        return [
            'api' => [
                HandleRPCExceptionsMiddleware::class,
            ],
        ];
    }

    /**
     * Override this method to configure route groups
     */
    protected function configureRouteGroups(GroupRegistry $groups): void
    {
        $groups
            ->setDefaultGroup('api');

        $groups->getGroup('api')->setPrefix('/api')->setNamePrefix('api.');
    }
}
