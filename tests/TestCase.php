<?php

declare(strict_types=1);

namespace Tests;

use Faker\Factory;
use Faker\Generator;
use Ramsey\Uuid\Uuid;
use Spiral\Config\ConfiguratorInterface;
use Spiral\Config\Patch\Set;
use Spiral\Core\Container;
use Spiral\Core\Container\Autowire;
use Spiral\Testing\TestableKernelInterface;
use Spiral\Testing\TestCase as BaseTestCase;
use Tests\App\TestKernel;

class TestCase extends BaseTestCase
{
    protected Generator $faker;

    protected function setUp(): void
    {
        $this->beforeBooting(static function (ConfiguratorInterface $config): void {
            if (!$config->exists('session')) {
                return;
            }

            $config->modify('session', new Set('handler', null));
        });

        parent::setUp();

        $this->faker = Factory::create();
    }

    /**
     * @template T
     * @param class-string<T>|string|Autowire $id
     * @return ($id is class-string ? T : mixed)
     * @throws \Throwable
     */
    public function get(string|Autowire $id): mixed
    {
        return $this->getContainer()->get($id);
    }

    public function createAppInstance(Container $container = new Container()): TestableKernelInterface
    {
        return TestKernel::create(
            directories: $this->defineDirectories(
                $this->rootDirectory(),
            ),
            container: $container,
        );
    }

    protected function tearDown(): void
    {
        // Uncomment this line if you want to clean up runtime directory.
        // $this->cleanUpRuntimeDirectory();
    }

    public function rootDirectory(): string
    {
        return __DIR__ . '/..';
    }

    public function defineDirectories(string $root): array
    {
        return [
            'root' => $root,
        ];
    }

    /**
     * @param class-string $attribute
     */
    public function hasAttribute(string $attribute): bool
    {
        return $this->getTestAttributes($attribute) !== [];
    }
}
