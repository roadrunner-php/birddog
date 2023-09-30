<?php

declare(strict_types=1);

namespace App\Interfaces\HTTP\Controller\v1\Plugin;

use App\Application\Command\Informer\PluginListQuery;
use App\Application\HTTP\Response\ResourceInterface;
use App\Interfaces\HTTP\DataGrid\v1\Plugin\PluginsSchema;
use App\Interfaces\HTTP\DataGrid\v1\Plugin\WorkersSchema;
use App\Interfaces\HTTP\Filter\v1\Plugin\ListRequest;
use App\Interfaces\HTTP\Resource\v1\Plugin\PluginCollection;
use App\Module\Informer\DTO\Plugin;
use Spiral\Cqrs\QueryBusInterface;
use Spiral\Router\Annotation\Route;

final readonly class ListAction
{
    public function __construct(
        private PluginsSchema $plugins,
        private WorkersSchema $workersSchema,
    ) {
    }

    #[Route('plugins', name: 'plugin.list', methods: 'GET')]
    public function __invoke(QueryBusInterface $bus, ListRequest $request,): ResourceInterface
    {
        $plugins = \array_map(function (Plugin $plugin): array {
            $plugin = $plugin->jsonSerialize();
            $plugin['workers'] = $this->workersSchema->create($plugin['workers']);
            return $plugin;
        }, $bus->ask(new PluginListQuery($request->server))->plugins);

        return new PluginCollection(
            $this->plugins->create($plugins),
        );
    }
}
