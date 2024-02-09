<?php

namespace App\Iterator;

use App\Contract\Connector\Mapper\MapperReadInterface;
use App\Contract\Connector\Repository\StorageReadInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Iterator;
use InvalidArgumentException;

class MappingRepositoryIteratorIterator extends \IteratorIterator
{
    public function __construct(
        \Traversable $iterator,
        ?string $class = null,
        private ?MapperReadInterface $mapper = null
    )
    {
        if (!$mapper instanceof MapperReadInterface) {
            throw new InvalidArgumentException('Mapper is required');
        }
        parent::__construct($iterator, $class);
    }

    public function current(): ArrayCollection
    {
        //todo check memory leak
        $result = new ArrayCollection();

        $parentResult = parent::current();
        foreach ($parentResult as $entityState) {
            $result->add($this->mapper->fromState($entityState));
        }

        return $result;
    }
}