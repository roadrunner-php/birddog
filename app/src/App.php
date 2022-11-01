<?php

declare(strict_types=1);

namespace App;

use App\Bootloader;
use Spiral\Boot\Bootloader\CoreBootloader;
use Spiral\Bootloader as Framework;
use Spiral\Cqrs\Bootloader\CqrsBootloader;
use Spiral\DotEnv\Bootloader as DotEnv;
use Spiral\EventBus\Bootloader\EventBusBootloader;
use Spiral\Events\Bootloader\EventsBootloader;
use Spiral\Framework\Kernel;
use Spiral\League\Event\Bootloader\EventBootloader;
use Spiral\Router\Bootloader\AnnotatedRoutesBootloader;
use Spiral\RoadRunnerBridge\Bootloader as RoadRunnerBridge;
use Spiral\Tokenizer\Bootloader\TokenizerBootloader;
use Spiral\Validation\Bootloader\ValidationBootloader;
use Spiral\Nyholm\Bootloader as Nyholm;
use Spiral\Validator\Bootloader\ValidatorBootloader;

class App extends Kernel
{
    protected const SYSTEM = [
        CoreBootloader::class,
        TokenizerBootloader::class,
        DotEnv\DotenvBootloader::class,
    ];

    protected const LOAD = [
        EventsBootloader::class,
        EventBootloader::class,

        // Logging and exceptions handling
        Bootloader\LoggingBootloader::class,
        Bootloader\ExceptionHandlerBootloader::class,

        // RoadRunner
        Nyholm\NyholmBootloader::class,
        RoadRunnerBridge\HttpBootloader::class,
        Framework\Http\RouterBootloader::class,
        AnnotatedRoutesBootloader::class,
        Framework\Http\JsonPayloadsBootloader::class,

        // Core Services
        Framework\SnapshotsBootloader::class,

        // Security and validation
        Framework\Security\EncrypterBootloader::class,
        ValidationBootloader::class,
        ValidatorBootloader::class,
        Framework\Security\FiltersBootloader::class,
        Framework\Security\GuardBootloader::class,

        // Framework commands
        Framework\CommandBootloader::class,

        // Debug and debug extensions
        CqrsBootloader::class,
    ];

    /*
     * Application specific services and extensions.
     */
    protected const APP = [
        Bootloader\RPCBootloader::class,
        Bootloader\RoutesBootloader::class,
    ];
}
