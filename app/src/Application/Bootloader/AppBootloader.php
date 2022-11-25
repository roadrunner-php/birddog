<?php

declare(strict_types=1);

namespace App\Application\Bootloader;

use App\Application\HTTP\Response\JsonResourceInterceptor;
use Spiral\Bootloader\DomainBootloader;
use Spiral\Core\CoreInterface;

final class AppBootloader extends DomainBootloader
{
    protected const INTERCEPTORS = [
        JsonResourceInterceptor::class,
    ];

    protected const SINGLETONS = [
        CoreInterface::class => [self::class, 'domainCore']
    ];
}
