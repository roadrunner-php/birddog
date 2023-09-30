<?php

declare(strict_types=1);

namespace App\Interfaces\HTTP\DataGrid\v1\Plugin;

use Doctrine\Common\Collections\ArrayCollection;
use Spiral\DataGrid\GridFactory;
use Spiral\DataGrid\GridInterface;
use Spiral\DataGrid\GridSchema;
use Spiral\DataGrid\Specification\Filter\Equals;
use Spiral\DataGrid\Specification\Sorter\Sorter;
use Spiral\DataGrid\Specification\SorterInterface;
use Spiral\DataGrid\Specification\Value;

final class WorkersSchema extends GridSchema
{
    public function __construct(
        private readonly GridFactory $factory,
        private readonly GridSchema $schema
    ) {
        $this->schema->addSorter('pid', new Sorter('pid'));
        $this->schema->addSorter('status', new Sorter('status'));
        $this->schema->addFilter('status', new Equals('status', new Value\EnumValue(new Value\IntValue(), 0, 1, 2)));
    }

    public function create(array $data): GridInterface
    {
        return $this->factory->withDefaults([
            GridFactory::KEY_SORT => ['pid' => SorterInterface::ASC],
        ])->create(
            new ArrayCollection($data),
            $this->schema
        );
    }
}
