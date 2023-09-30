<?php

declare(strict_types=1);

namespace Tests\Feature\Interfaces\Http\Controller\v1\Settings;

use App\Module\Settings\SettingsRepositoryInterface;
use Tests\Feature\Interfaces\Http\Controller\ControllerTestCase;

final class StoreActionTest extends ControllerTestCase
{
    public function testStore(): void
    {
        $repository = $this->mockContainer(SettingsRepositoryInterface::class);

        $repository->shouldReceive('store')->once()->with([
            'foo' => 'bar',
        ]);

        $this->http->settingsStore([
            'foo' => 'bar',
        ])->assertStatusResource();
    }
}
