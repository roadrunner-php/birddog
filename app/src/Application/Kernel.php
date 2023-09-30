<?php

declare(strict_types=1);

namespace App\Application;

use App\Application\Bootloader;
use Spiral\Boot\Bootloader\CoreBootloader;
use Spiral\Bootloader as Framework;
use Spiral\Cqrs\Bootloader\CqrsBootloader;
use Spiral\DataGrid\Bootloader\GridBootloader;
use Spiral\DotEnv\Bootloader as DotEnv;
use Spiral\Framework\Kernel as BaseKernel;
use Spiral\League\Event\Bootloader\EventBootloader;
use Spiral\Nyholm\Bootloader as Nyholm;
use Spiral\RoadRunnerBridge\Bootloader as RoadRunnerBridge;
use Spiral\Serializer\Bootloader\SerializerBootloader;
use Spiral\Tokenizer\Bootloader\TokenizerBootloader;
use Spiral\Tokenizer\Bootloader\TokenizerListenerBootloader;
use Spiral\Validation\Bootloader\ValidationBootloader;
use Spiral\Validator\Bootloader\ValidatorBootloader;

class Kernel extends BaseKernel
{
   protected function defineSystemBootloaders(): array
   {
       return [
           CoreBootloader::class,
           DotEnv\DotenvBootloader::class,
           TokenizerListenerBootloader::class,
       ];
   }

    protected function defineBootloaders(): array
    {
        return [
            SerializerBootloader::class,

            // RoadRunner
            Nyholm\NyholmBootloader::class,
            RoadRunnerBridge\HttpBootloader::class,
            RoadRunnerBridge\CacheBootloader::class,
            // RoadRunnerBridge\QueueBootloader::class,
            RoadRunnerBridge\CentrifugoBootloader::class,
            RoadRunnerBridge\LoggerBootloader::class,

            EventBootloader::class,

            // Logging and exceptions handling
            Bootloader\ExceptionHandlerBootloader::class,

            Framework\Http\JsonPayloadsBootloader::class,
            // Framework\Security\GuardBootloader::class,
            Bootloader\RoutesBootloader::class,

            // Core Services
            Framework\SnapshotsBootloader::class,

            // Security and validation
            Framework\Security\EncrypterBootloader::class,
            Framework\Security\FiltersBootloader::class,
            ValidationBootloader::class,
            ValidatorBootloader::class,

            Framework\CommandBootloader::class,

            CqrsBootloader::class,
            GridBootloader::class,

            Bootloader\RPCBootloader::class,
            Bootloader\HttpClientBootloader::class,
            Bootloader\PrometheusParserBootloader::class,
            Bootloader\ValidatorBootloader::class,
            Bootloader\VictoriaMetricsBootloader::class,
            Bootloader\AppBootloader::class,
            Bootloader\ServerBootloader::class,
        ];
    }
}
