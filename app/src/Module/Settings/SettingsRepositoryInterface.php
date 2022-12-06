<?php

declare(strict_types=1);

namespace App\Module\Settings;

interface SettingsRepositoryInterface
{
    public function get(): array;

    public function store(array $settings): void;
}
