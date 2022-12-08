<?php

declare(strict_types=1);

namespace App\Application\Schema;

use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\Expr\Comparison;
use Spiral\DataGrid\Compiler;
use Spiral\DataGrid\Specification\Filter\Equals;
use Spiral\DataGrid\Specification\Filter\Like;
use Spiral\DataGrid\Specification\Sorter\AbstractSorter;
use Spiral\DataGrid\SpecificationInterface;
use Spiral\DataGrid\WriterInterface;

final class DoctrineCollectionWriter implements WriterInterface
{
    public function write(mixed $source, SpecificationInterface $specification, Compiler $compiler): mixed
    {
        if (!$source instanceof Collection) {
            return $source;
        }

        $criteria = null;

        if ($specification instanceof AbstractSorter) {
            $orders = [];
            foreach ($specification->getExpressions() as $field) {
                $orders[$field] = ($specification->getValue() === AbstractSorter::ASC)
                    ? Criteria::ASC
                    : Criteria::DESC;
            }

            if ($orders !== []) {
                $criteria = (new Criteria())->orderBy($orders);
            }
        } elseif ($specification instanceof Equals) {
            $expr = new Comparison($specification->getExpression(), Comparison::EQ, $specification->getValue());
            $criteria = (new Criteria())->where($expr);
        } elseif ($specification instanceof Like) {
            $criteria = new Criteria(
                Criteria::expr()->contains($specification->getExpression(), $specification->getValue())
            );
        }

        if ($criteria !== null) {
            $source = $source->matching($criteria)->getValues();
        }

        return $source;
    }
}
