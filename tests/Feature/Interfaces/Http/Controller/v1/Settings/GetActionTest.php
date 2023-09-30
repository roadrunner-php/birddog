<?php

declare(strict_types=1);

namespace Tests\Feature\Interfaces\Http\Controller\v1\Settings;

use App\Module\Settings\SettingsRepositoryInterface;
use Tests\Feature\Interfaces\Http\Controller\ControllerTestCase;

final class GetActionTest extends ControllerTestCase
{
    public function testGetSettings(): void
    {
        $repository = $this->mockContainer(SettingsRepositoryInterface::class);

        $repository->shouldReceive('get')->once()->andReturn([
            'foo' => 'bar',
        ]);

        $this->http->settingsList()->assertJsonResponseSame([
            'data' => [
                'foo' => 'bar',
            ]
        ]);
    }
}
