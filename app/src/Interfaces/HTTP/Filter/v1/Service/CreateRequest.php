<?php

declare(strict_types=1);

namespace App\Interfaces\HTTP\Filter\v1\Service;

use App\Interfaces\HTTP\Filter\v1\AbstractServerFilter;
use Spiral\Filters\Attribute\Input\Post;
use Spiral\Filters\Attribute\Setter;

final class CreateRequest extends AbstractServerFilter
{
    #[Post]
    public string $server;

    #[Post]
    public string $name;

    #[Post]
    public string $command;

    #[Setter('intval')]
    #[Post(key: 'process_num')]
    public int $processNum = 1;

    #[Setter('intval')]
    #[Post(key: 'exec_timeout')]
    public int $execTimeout = 0;

    #[Setter('boolval')]
    #[Post(key: 'remain_after_exit')]
    public bool $remainAfterExit = false;

    #[Setter('intval')]
    #[Post(key: 'restart_sec')]
    public int $restartSec = 30;

    #[Post]
    public array $env = [];

    protected function getValidationRules(): array
    {
        $rules = parent::getValidationRules();
        $rules['name'] = ['required', 'string', 'custom:serviceName'];
        $rules['command'] = ['required', 'string'];
        $rules['processNum'] = ['int'];
        $rules['execTimeout'] = ['int'];
        $rules['restartSec'] = ['int'];
        $rules['remainAfterExit'] = ['bool'];
        $rules['env'] = ['is_array'];

        return $rules;
    }
}
