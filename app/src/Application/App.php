<?php

declare(strict_types=1);

namespace App\Application;

use App\Application\Bootloader;
use Spiral\Boot\Bootloader\CoreBootloader;
use Spiral\Bootloader as Framework;
use Spiral\Cqrs\Bootloader\CqrsBootloader;
use Spiral\DataGrid\Bootloader\GridBootloader;
use Spiral\DotEnv\Bootloader as DotEnv;
use Spiral\Framework\Kernel;
use Spiral\League\Event\Bootloader\EventBootloader;
use Spiral\Nyholm\Bootloader as Nyholm;
use Spiral\RoadRunnerBridge\Bootloader as RoadRunnerBridge;
use Spiral\Serializer\Bootloader\SerializerBootloader;
use Spiral\Tokenizer\Bootloader\TokenizerBootloader;
use Spiral\Validation\Bootloader\ValidationBootloader;
use Spiral\Validator\Bootloader\ValidatorBootloader;

class App extends Kernel
{
    protected const SYSTEM = [
        CoreBootloader::class,
        TokenizerBootloader::class,
        DotEnv\DotenvBootloader::class,
    ];

    protected const LOAD = [
        SerializerBootloader::class,

        // RoadRunner
        Nyholm\NyholmBootloader::class,
        RoadRunnerBridge\HttpBootloader::class,
        RoadRunnerBridge\CacheBootloader::class,
        RoadRunnerBridge\QueueBootloader::class,
        RoadRunnerBridge\CentrifugoBootloader::class,
        RoadRunnerBridge\LoggerBootloader::class,

        EventBootloader::class,

        // Logging and exceptions handling
        Bootloader\LoggingBootloader::class,
        Bootloader\ExceptionHandlerBootloader::class,

        Framework\Http\JsonPayloadsBootloader::class,
        Framework\Security\FiltersBootloader::class,
        Framework\Security\GuardBootloader::class,
        Bootloader\RoutesBootloader::class,

        // Core Services
        Framework\SnapshotsBootloader::class,

        // Security and validation
        Framework\Security\EncrypterBootloader::class,
        ValidationBootloader::class,
        ValidatorBootloader::class,

        Framework\CommandBootloader::class,

        CqrsBootloader::class,
        GridBootloader::class,
    ];

    /*
     * Application specific services and extensions.
     */
    protected const APP = [
        Bootloader\RPCBootloader::class,
        Bootloader\HttpClientBootloader::class,
        Bootloader\PrometheusParserBootloader::class,
        Bootloader\ValidatorBootloader::class,
        Bootloader\VictoriaMetricsBootloader::class,
        Bootloader\AppBootloader::class,
    ];
}
