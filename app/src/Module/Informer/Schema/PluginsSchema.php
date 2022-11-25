<?php

declare(strict_types=1);

namespace App\Module\Informer\Schema;

use Doctrine\Common\Collections\ArrayCollection;
use Spiral\DataGrid\GridFactory;
use Spiral\DataGrid\GridFactoryInterface;
use Spiral\DataGrid\GridInterface;
use Spiral\DataGrid\GridSchema;
use Spiral\DataGrid\Specification\Filter\Equals;
use Spiral\DataGrid\Specification\Sorter\Sorter;
use Spiral\DataGrid\Specification\SorterInterface;
use Spiral\DataGrid\Specification\Value\BoolValue;

final class PluginsSchema extends GridSchema
{
    public function __construct(
        private readonly GridFactoryInterface $factory,
        private readonly GridSchema $schema
    ) {
        $this->schema->addSorter('name', new Sorter('name'));
        $this->schema->addFilter('ressetable', new Equals('is_ressetable', new BoolValue()));
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

