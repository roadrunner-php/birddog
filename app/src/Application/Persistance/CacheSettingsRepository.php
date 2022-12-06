<?php

declare(strict_types=1);

namespace App\Application\Persistance;

use App\Module\Settings\SettingsRepositoryInterface;
use Psr\SimpleCache\CacheInterface;

final class CacheSettingsRepository implements SettingsRepositoryInterface
{
    public function __construct(
        private readonly CacheInterface $cache
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
