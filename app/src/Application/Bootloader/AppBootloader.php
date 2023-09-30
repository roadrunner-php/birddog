<?php

declare(strict_types=1);

namespace App\Application\Bootloader;

use App\Application\HTTP\Interceptor\JsonResourceInterceptor;
use App\Infrastructure\RoadRunner\CacheSettingsRepository;
use App\Module\Settings\SettingsRepositoryInterface;
use Spiral\Bootloader\DomainBootloader;
use Spiral\Core\CoreInterface;

final class AppBootloader extends DomainBootloader
{
    protected static function defineInterceptors(): array
    {
        return [
            JsonResourceInterceptor::class,
        ];
    }

    public function defineSingletons(): array
    {
        return [
            SettingsRepositoryInterface::class => CacheSettingsRepository::class,
            CoreInterface::class => [self::class, 'domainCore'],
        ];
    }
}
