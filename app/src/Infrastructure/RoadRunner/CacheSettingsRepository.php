<?php

declare(strict_types=1);

namespace App\Infrastructure\RoadRunner;

use App\Module\Settings\SettingsRepositoryInterface;
use Psr\SimpleCache\CacheInterface;

final readonly class CacheSettingsRepository implements SettingsRepositoryInterface
{
    public function __construct(
        private CacheInterface $cache
    ) {
    }

    public function get(): array
    {
        return (array)$this->cache->get('settings', []);
    }

    public function store(array $settings): void
    {
        $this->cache->set('settings', $settings);
    }
}
