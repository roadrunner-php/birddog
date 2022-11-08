<?php

declare(strict_types=1);

namespace App\Security;

use Spiral\Validator\AbstractChecker;

final class ValidationRules extends AbstractChecker
{
    public const MESSAGES = [
        'uuid' => 'Invalid uuid.',
        'metricsKey' => 'Invalid metrics key.',
        'pipelineName' => 'Invalid pipeline name.',
        'pluginName' => 'Invalid plugin name.',
        'serviceName' => 'Invalid service name.',
        'serverName' => 'Invalid server name.',
        'tcpAddress' => 'Invalid TCP address.',
    ];

    public function tags(array $tags): bool
    {
        foreach ($tags as $name => $value) {
            if (empty($name) || ($value === null || $value === '')) {
                return false;
            }
        }

        return true;
    }

    public function uuid(string $uuid): bool
    {
        return \preg_match('/^\w{8}-\w{4}-\w{4}-\w{4}-\w{12}$/i', $uuid) === 1;
    }

    public function metricsKey(string $key): bool
    {
        return \preg_match('/^[a-z0-9_]+$/i', $key) === 1;
    }

    public function pipelineName(string $name): bool
    {
        return \preg_match('/^[a-zA-Z0-9\.\_\-]+$/i', $name) === 1;
    }

    public function pluginName(string $name): bool
    {
        return \preg_match('/^[a-zA-Z0-9\_\-]+$/i', $name) === 1;
    }

    public function serviceName(string $name): bool
    {
        return \preg_match('/^[a-zA-Z0-9\.\_\-]+$/i', $name) === 1;
    }

    public function serverName(string $name): bool
    {
        return $this->metricsKey($name);
    }

    public function tcpAddress(string $address): bool
    {
        return \preg_match('/^tcp:\/\/[a-z0-9\.\-_]+(:[0-9]{0,5})?$/i', $address) === 1;
    }
}
