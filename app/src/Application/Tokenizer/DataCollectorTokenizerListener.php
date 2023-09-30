<?php

declare(strict_types=1);

namespace App\Application\Tokenizer;

use App\Domain\Server\Collector\CollectorInterface;
use App\Domain\Server\Collector\DataCollectorRegistryInterface;
use App\Domain\Server\Collector\DataCollectorRepositoryInterface;
use Spiral\Core\Attribute\Singleton;
use Spiral\Core\FactoryInterface;
use Spiral\Tokenizer\Attribute\TargetClass;
use Spiral\Tokenizer\TokenizationListenerInterface;

#[Singleton]
#[TargetClass(class: CollectorInterface::class)]
final class DataCollectorTokenizerListener implements DataCollectorRepositoryInterface,
                                                      DataCollectorRegistryInterface,
                                                      TokenizationListenerInterface
{
    /**
     * List of registered collectors.
     * @var array<CollectorInterface>
     */
    private array $collectors = [];

    public function __construct(
        private readonly FactoryInterface $factory,
    ) {
    }

    public function register(CollectorInterface $collector): void
    {
        $this->collectors[] = $collector;
    }

    public function get(): array
    {
        return $this->collectors;
    }

    public function listen(\ReflectionClass $class): void
    {
        $this->register(
            $this->factory->make($class->getName()),
        );
    }

    public function finalize(): void
    {
        // do nothing
    }
}
