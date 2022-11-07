<?php

declare(strict_types=1);

namespace App\Bootloader;

use Spiral\Boot\Bootloader\Bootloader;
use Symfony\Component\HttpClient\NativeHttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class HttpClientBootloader extends Bootloader
{
    protected const SINGLETONS = [
        HttpClientInterface::class => NativeHttpClient::class,
    ];
}
