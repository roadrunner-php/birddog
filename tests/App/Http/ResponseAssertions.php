<?php

declare(strict_types=1);

namespace Tests\App\Http;

use App\Application\HTTP\Response\ResourceInterface;
use App\Application\HTTP\Response\StatusResource;
use PHPUnit\Framework\TestCase;
use Spiral\Testing\Http\TestResponse;

/**
 * @mixin TestResponse
 */
final readonly class ResponseAssertions
{
    public function __construct(
        private TestResponse $response,
    ) {
    }

    public function assertNotFoundResource(string $message = 'Not found'): self
    {
        return $this
            ->assertNotFound()
            ->assertBodySame(
                \json_encode([
                    'message' => $message,
                    'code' => 404,
                ]),
            );
    }

    public function assertForbiddenResource(string $message = 'Forbidden'): self
    {
        return $this
            ->assertForbidden()
            ->assertBodySame(
                \json_encode([
                    'message' => $message,
                    'code' => 403,
                ]),
            );
    }

    public function assertResource(ResourceInterface $resource): self
    {
        $needle = \json_encode($resource);
        TestCase::assertSame(
            $needle,
            (string)$this->response,
            \sprintf('Response is not same with [%s]', $needle),
        );

        return $this;
    }

    /**
     * @param ResourceInterface[] $resources
     */
    public function assertCollectionContainResources(array $resources): self
    {
        foreach ($resources as $resource) {
            $this->assertCollectionHasResource($resource);
        }

        return $this;
    }

    /**
     * @param ResourceInterface[] $resources
     */
    public function assertCollectionMissingResources(array $resources): self
    {
        foreach ($resources as $resource) {
            $this->assertCollectionMissingResource($resource);
        }

        return $this;
    }

    public function assertCollectionHasResource(ResourceInterface $resource): self
    {
        $needle = \json_encode($resource);
        $responseData = \json_decode((string)$this->response, true);


        foreach ($responseData['data'] as $item) {
            if ($needle === \json_encode($item)) {
                return $this;
            }
        }

        TestCase::fail(
            \sprintf('Response does not contain resource [%s]', $needle),
        );
    }

    public function assertCollectionMissingResource(ResourceInterface $resource): self
    {
        $needle = \json_encode($resource);
        $responseData = \json_decode((string)$this->response, true);

        foreach ($responseData['data'] as $item) {
            if ($needle === \json_encode($item)) {
                TestCase::fail(
                    \sprintf('Response contains resource [%s]', $needle),
                );
            }
        }

        return $this;
    }

    public function assertStatusResource(bool $status = true): self
    {
        return $this->assertOk()->assertResource(new StatusResource($status));
    }

    public function assertJsonResponseSame(array $data): self
    {
        $needle = \json_encode($data);
        TestCase::assertSame(
            $needle,
            (string)$this->response,
            \sprintf('Response is not same with [%s]', $needle),
        );

        return $this;
    }

    public function assertJsonResponseContains(array $data): self
    {
        $needle = \json_encode($data);
        $responseData = \json_decode((string)$this->response, true);

        $intersection = \array_intersect_key($responseData, $data);

        $diff = [];

        foreach ($data as $key => $value) {
            if ($intersection[$key] !== $value) {
                $diff[] = $key;
            }
        }

        TestCase::assertSame(
            $needle,
            \json_encode($intersection),
            \sprintf('The following keys are not same: [%s]', \implode(', ', $diff)),
        );

        return $this;
    }

    public function assertValidationErrors(array $data): self
    {
        $responseData = \json_decode((string)$this->response, true);

        if (!\array_is_list($data)) {
            foreach ($data as $key => $value) {
                TestCase::assertArrayHasKey(
                    $key,
                    $responseData['errors'],
                    \sprintf('Validation error for key [%s] not found', $key),
                );

                TestCase::assertSame(
                    $value,
                    $responseData['errors'][$key],
                    \sprintf('Validation error for key [%s] is not same', $key),
                );
            }
        } else {
            $diff = \array_diff($data, \array_keys($responseData['errors']));

            TestCase::assertEmpty(
                $diff,
                \sprintf('Validation errors for keys [%s] not found', \implode(', ', $diff)),
            );
        }

        return $this
            ->assertJsonResponseContains([
                'message' => 'The given data was invalid.',
                'code' => 422,
                'context' => null,
            ])
            ->assertUnprocessable();
    }

    public function __call(string $name, array $arguments): self
    {
        if (!method_exists($this->response, $name)) {
            throw new \Exception("Method $name does not exist");
        }

        $this->response->$name(...$arguments);

        return $this;
    }
}
