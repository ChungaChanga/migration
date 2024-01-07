<?php

namespace App\Iterator;

use Chungachanga\AbstractMigration\Mapper\MapperReadInterface;
use Traversable;

class MapperReadIterator extends \IteratorIterator
{
    public function __construct(
        Traversable $iterator,
        ?string $class = '',
        private ?MapperReadInterface $mapper = null
    )
    {
        parent::__construct($iterator, $class);
    }

    public function current(): mixed
    {
        $result = [];
        foreach (parent::current() as $value) {
            $result[] = $this->mapper->fromState($value);
        }
        return $result;
    }

}