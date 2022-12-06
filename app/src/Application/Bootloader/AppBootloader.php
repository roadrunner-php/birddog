<?php

declare(strict_types=1);

namespace App\Application\Bootloader;

use App\Application\HTTP\Response\JsonResourceInterceptor;
use App\Application\Persistance\CacheSettingsRepository;
use App\Module\Settings\SettingsRepositoryInterface;
use Spiral\Bootloader\DomainBootloader;
use Spiral\Core\CoreInterface;

final class AppBootloader extends DomainBootloader
{
    protected const INTERCEPTORS = [
        JsonResourceInterceptor::class,
    ];

    protected const SINGLETONS = [
        SettingsRepositoryInterface::class => CacheSettingsRepository::class,
        CoreInterface::class => [self::class, 'domainCore'],
    ];
}
