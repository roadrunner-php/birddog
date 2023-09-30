<?php

declare(strict_types=1);

namespace App\Interfaces\HTTP\DataGrid\v1\Jobs;

use Doctrine\Common\Collections\ArrayCollection;
use Spiral\DataGrid\GridFactory;
use Spiral\DataGrid\GridInterface;
use Spiral\DataGrid\GridSchema;
use Spiral\DataGrid\Specification\Filter\Equals;
use Spiral\DataGrid\Specification\Sorter\Sorter;
use Spiral\DataGrid\Specification\SorterInterface;
use Spiral\DataGrid\Specification\Value\BoolValue;
use Spiral\DataGrid\Specification\Value\StringValue;

final class PipelinesSchema extends GridSchema
{
    public function __construct(
        private readonly GridFactory $factory,
        private readonly GridSchema $schema
    ) {
        $this->schema->addSorter('pipeline', new Sorter('pipeline'));
        $this->schema->addSorter('priority', new Sorter('priority'));
        $this->schema->addFilter('driver', new Equals('driver', new StringValue()));
        $this->schema->addFilter('active', new Equals('active', new BoolValue()));
    }

    public function create(array $data): GridInterface
    {
        return $this->factory->withDefaults([
            GridFactory::KEY_SORT => ['pipeline' => SorterInterface::ASC],
        ])->create(
            new ArrayCollection($data),
            $this->schema
        );
    }
}
