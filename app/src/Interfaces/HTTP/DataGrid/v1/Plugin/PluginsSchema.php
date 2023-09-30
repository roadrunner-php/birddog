<?php

declare(strict_types=1);

namespace App\Interfaces\HTTP\DataGrid\v1\Plugin;

use App\Module\Informer\DTO\Plugin;
use Doctrine\Common\Collections\ArrayCollection;
use Spiral\DataGrid\GridFactory;
use Spiral\DataGrid\GridInterface;
use Spiral\DataGrid\GridSchema;
use Spiral\DataGrid\Specification\Filter\Equals;
use Spiral\DataGrid\Specification\Sorter\Sorter;
use Spiral\DataGrid\Specification\SorterInterface;
use Spiral\DataGrid\Specification\Value\BoolValue;

final class PluginsSchema extends GridSchema
{
    public function __construct(
        private readonly GridFactory $factory,
        private readonly GridSchema $schema
    ) {
        $this->schema->addSorter('name', new Sorter('name'));
        $this->schema->addFilter('resettable', new Equals('is_resettable', new BoolValue()));
    }

    public function create(array $data): GridInterface
    {
        return $this->factory->withDefaults([
            GridFactory::KEY_SORT => ['name' => SorterInterface::ASC],
        ])->create(
            new ArrayCollection($data),
            $this->schema
        );
    }
}

