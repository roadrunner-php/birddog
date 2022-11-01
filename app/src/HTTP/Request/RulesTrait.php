<?php

declare(strict_types=1);

namespace App\HTTP\Request;

trait RulesTrait
{
    private function serverRules(array $serversNames): array
    {
        return [
            'required',
            'string',
            ['in_array', $serversNames, true, 'error' => 'Invalid service.'],
        ];
    }
}
