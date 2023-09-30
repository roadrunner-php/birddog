<?php

declare(strict_types=1);

namespace App\Application\Bootloader;

use App\Infrastructure\VictoriaMetrics\Client;
use App\Infrastructure\VictoriaMetrics\ClientInterface;
use Spiral\Boot\Bootloader\Bootloader;
use Spiral\Boot\EnvironmentInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class VictoriaMetricsBootloader extends Bootloader
{
    public function defineSingletons(): array
    {
        return [
            ClientInterface::class => [self::class, 'initClient'],
        ];
    }

    private function initClient(
        HttpClientInterface $client,
        EnvironmentInterface $env,
    ): ClientInterface {
        $headers = [
            'content-type' => 'application/json',
        ];

        return new Client(
            $client->withOptions([
                'base_uri' => $env->get('VICTORIA_METRICS_WRITE_URL', 'http://127.0.0.1:4242'),
                'headers' => $headers,
            ]),
            $client->withOptions([
                'base_uri' => $env->get('VICTORIA_METRICS_QUERY_URL', 'http://127.0.0.1:8428'),
                'headers' => $headers,
            ]),
        );
    }
}
