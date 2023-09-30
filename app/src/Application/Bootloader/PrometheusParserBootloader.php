<?php

declare(strict_types=1);

namespace App\Application\Bootloader;

use Butschster\Prometheus\Parser;
use Butschster\Prometheus\ParserFactory;
use Spiral\Boot\Bootloader\Bootloader;

final class PrometheusParserBootloader extends Bootloader
{
    public function defineSingletons(): array
    {
        return [
            Parser::class => [self::class, 'initParser'],
        ];
    }

    private function initParser(): Parser
    {
        return ParserFactory::create();
    }
}
