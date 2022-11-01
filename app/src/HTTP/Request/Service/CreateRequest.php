<?php

declare(strict_types=1);

namespace App\HTTP\Request\Service;

use App\HTTP\Request\RulesTrait;
use App\RPC\ServersRegistryInterface;
use Spiral\Filters\Attribute\Input\Post;
use Spiral\Filters\Attribute\Setter;
use Spiral\Filters\Model\Filter;
use Spiral\Filters\Model\FilterDefinitionInterface;
use Spiral\Filters\Model\HasFilterDefinition;
use Spiral\Validator\FilterDefinition;

final class CreateRequest extends Filter implements HasFilterDefinition
{
    use RulesTrait;

    public function __construct(
        private readonly ServersRegistryInterface $registry
    ) {
    }

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

    public function filterDefinition(): FilterDefinitionInterface
    {
        return new FilterDefinition([
            'server' => $this->serverRules($this->registry->getServersNames()),
            'name' => ['required', 'string'],
            'command' => ['required', 'string'],
            'processNum' => ['int'],
            'execTimeout' => ['int'],
            'remainAfterExit' => ['bool'],
            'restartSec' => ['int'],
            'env' => ['is_array'],
        ]);
    }
}
