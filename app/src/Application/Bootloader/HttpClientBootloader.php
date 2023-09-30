<?php

declare(strict_types=1);

namespace App\Application\Bootloader;

use Spiral\Boot\Bootloader\Bootloader;
use Symfony\Component\HttpClient\NativeHttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class HttpClientBootloader extends Bootloader
{
    public function defineSingletons(): array
    {
        return [
            HttpClientInterface::class => NativeHttpClient::class,
        ];
    }
}
